<?php

namespace JackSleight\StatamicMembers\Http\Controllers\CP;

use Illuminate\Http\Request;
use Statamic\Facades\Scope;
use Statamic\Http\Requests\FilteredRequest;
use Statamic\Http\Resources\CP\Users\Users;
use Statamic\Facades\User;
use Statamic\Contracts\Auth\User as UserContract;
use Statamic\CP\Column;
use Statamic\Exceptions\NotFoundHttpException;
use Statamic\Auth\Passwords\PasswordReset;
use JackSleight\StatamicMembers\Notifications\ActivateAccount;
use Statamic\Http\Controllers\CP\Users\UsersController as StatamicUsersController;

class UsersController extends StatamicUsersController
{
    /**
     * @var UserContract
     */
    private $user;

    public function index(FilteredRequest $request)
    {
        $this->authorize('view members', UserContract::class);

        if ($request->wantsJson()) {
            return $this->json($request);
        }

        return view('statamic-members::cp.users.index', [
            'filters' => Scope::filters('users'),
        ]);
    }
    
    protected function json($request)
    {
        $query = User::query();

        $activeFilterBadges = $this->queryFilters($query, $request->filters);

        if ($search = request('search')) {
            $query->where('email', 'like', '%'.$search.'%');
        }

        if ($roles = config('statamic.users.new_user_roles')) {
            foreach ($roles as $role) {
                $query->where('roles/'.$role, true);
            }
        }

        if ($groups = config('statamic.users.new_user_groups')) {
            foreach ($groups as $group) {
                $query->where('groups/'.$group, true);
            }
        }

        $users = $query
            ->orderBy($sort = request('sort', 'email'), request('order', 'asc'))
            ->paginate(request('perPage'));

        return (new Users($users))
            ->blueprint($blueprint = User::blueprint())
            ->columns(collect([
                Column::make('email')->label(__('Email')),
                $blueprint->hasField('name') ? Column::make('name')->label(__('Name')) : null,
                $blueprint->hasField('first_name') ? Column::make('first_name')->label(__('First Name')) : null,
                $blueprint->hasField('last_name') ? Column::make('last_name')->label(__('Last Name')) : null,
                Column::make('last_login')->label(__('Last Login'))->sortable(false),
            ])->filter()->values()->all())
            ->additional(['meta' => [
                'activeFilterBadges' => $activeFilterBadges,
            ]]);
    }

    public function create(Request $request)
    {
        $this->authorizePro();
        $this->authorize('create members', UserContract::class);

        $blueprint = User::blueprint();

        $fields = $blueprint->fields()->preProcess();

        $broker = config('statamic.users.passwords.'.PasswordReset::BROKER_ACTIVATIONS);
        $expiry = config("auth.passwords.{$broker}.expire") / 60;

        $viewData = [
            'title' => __('Create'),
            'values' => $fields->values()->all(),
            'meta' => $fields->meta(),
            'blueprint' => $blueprint->toPublishArray(),
            'actions' => [
                'save' => cp_route('members.store'),
            ],
            'expiry' => $expiry,
            'separateNameFields' => $blueprint->hasField('first_name'),
        ];

        if ($request->wantsJson()) {
            return $viewData;
        }

        return view('statamic-members::cp.users.create', $viewData);
    }

    public function store(Request $request)
    {
        $this->authorizePro();
        $this->authorize('create members', UserContract::class);

        $blueprint = User::blueprint();

        $fields = $blueprint->fields()->only(['email', 'name', 'first_name', 'last_name'])->addValues($request->all());

        $fields->validate(['email' => 'required|email|unique_user_value']);

        $values = $fields->process()->values()->except(['email', 'groups', 'roles']);

        $user = User::make()
            ->email($request->email)
            ->data($values);

        if ($roles = config('statamic.users.new_user_roles')) {
            $user->roles($roles);
        }

        if ($groups = config('statamic.users.new_user_groups')) {
            $user->groups($groups);
        }

        $user->save();

        PasswordReset::resetFormRoute('statamic.members.activate');
        PasswordReset::redirectAfterReset(null);
        $token = $user->generateActivateAccountToken();

        if ($request->invitation['send']) {
            ActivateAccount::subject($request->invitation['subject']);
            ActivateAccount::body($request->invitation['message']);
            $user->notify(new ActivateAccount($token));
            $url = null;
        } else {
            $url = PasswordReset::url($token, PasswordReset::BROKER_ACTIVATIONS);
        }

        return [
            'redirect' => cp_route('members.edit', $user->id()),
            'activationUrl' => $url,
        ];
    }

    public function edit(Request $request, $user)
    {
        throw_unless($user = User::find($user), new NotFoundHttpException);
        throw_unless(authorize_member($user), new NotFoundHttpException);

        $this->authorize('edit members', $user);

        $blueprint = $user->blueprint();

        $fields = $blueprint
            ->removeField('password')
            ->removeField('password_confirmation')
            ->removeField('roles')
            ->removeField('groups')
            ->fields()
            ->addValues($user->data()->merge(['email' => $user->email()])->all())
            ->preProcess();

        $viewData = [
            'title' => $user->email(),
            'values' => $fields->values()->all(),
            'meta' => $fields->meta(),
            'blueprint' => $user->blueprint()->toPublishArray(),
            'reference' => $user->reference(),
            'actions' => [
                'save' => cp_route('members.update', $user->id()),
                'password' => cp_route('users.password.update', $user->id()),
            ],
            'canEditPassword' => User::fromUser($request->user())->can('editPassword', $user),
        ];

        if ($request->wantsJson()) {
            return $viewData;
        }

        return view('statamic-members::cp.users.edit', $viewData);
    }

    public function update(Request $request, $user)
    {
        throw_unless($user = User::find($user), new NotFoundHttpException);
        throw_unless(authorize_member($user), new NotFoundHttpException);

        $this->authorize('edit members', $user);

        $fields = $user->blueprint()->fields()->except(['password'])->addValues($request->all());

        $fields->validate(['email' => 'required|unique_user_value:'.$user->id()]);

        $values = $fields->process()->values()->except(['email', 'groups', 'roles']);

        foreach ($values as $key => $value) {
            $user->set($key, $value);
        }
        $user->email($request->email);

        $user->save();

        return ['title' => $user->title()];
    }
}