<?php

namespace JackSleight\StatamicMemberbox\Http\Controllers\CP;

use Illuminate\Http\Request;
use JackSleight\StatamicMemberbox\Facades\Member;
use JackSleight\StatamicMemberbox\Http\Resources\CP\Members\Members;
use JackSleight\StatamicMemberbox\Notifications\ActivateAccount;
use Statamic\Auth\Passwords\PasswordReset;
use Statamic\Contracts\Auth\User as UserContract;
use Statamic\Exceptions\FatalException;
use Statamic\Exceptions\NotFoundHttpException;
use Statamic\Facades\File;
use Statamic\Facades\Scope;
use Statamic\Facades\User;
use Statamic\Http\Controllers\CP\Users\UsersController;
use Statamic\Http\Requests\FilteredRequest;
use Statamic\Support\Str;
use Statamic\Rules\UniqueUserValue;

class MembersController extends UsersController
{
    /**
     * @var UserContract
     */
    private $user;

    public function index(FilteredRequest $request)
    {
        $this->authorize('mb view members', UserContract::class);

        if ($request->wantsJson()) {
            return $this->json($request);
        }

        if (! count(config('statamic.users.new_user_roles', [])) && ! count(config('statamic.users.new_user_groups', []))) {
            return view('statamic-memberbox::cp.members.incomplete');
        }

        if (Member::query()->count() === 0) {
            return view('statamic-memberbox::cp.members.empty');
        }

        return view('statamic-memberbox::cp.members.index', [
            'filters' => Scope::filters('users'),
        ]);
    }

    protected function indexQuery()
    {
        $query = Member::query();

        if ($search = request('search')) {
            $query->where(function ($query) use ($search) {
                $query->where('email', 'like', '%'.$search.'%')->orWhere('name', 'like', '%'.$search.'%');
            });
        }

        return $query;
    }

    protected function json($request)
    {
        $this->authorize('mb view members', UserContract::class);

        $query = $this->indexQuery();

        $activeFilterBadges = $this->queryFilters($query, $request->filters);

        $users = $query
            ->orderBy($sort = request('sort', 'email'), request('order', 'asc'))
            ->paginate(request('perPage'));

        return (new Members($users))
            ->blueprint($blueprint = User::blueprint())
            ->columnPreferenceKey('mb_members.columns')
            ->additional(['meta' => [
                'activeFilterBadges' => $activeFilterBadges,
            ]]);
    }

    public function create(Request $request)
    {
        $this->authorizePro();
        $this->authorize('mb create members', UserContract::class);

        $blueprint = User::blueprint();

        $only = array_merge(['email'], config('statamic.memberbox.cp_create_fields'));
        $except = ['groups', 'roles', 'password'];

        $fields = $blueprint->fields()->only($only)->except($except)->preProcess();

        $broker = config('statamic.users.passwords.'.PasswordReset::BROKER_ACTIVATIONS);
        $expiry = config("auth.passwords.{$broker}.expire") / 60;

        $viewData = [
            'title' => __('Create'),
            'values' => $fields->values()->all(),
            'blueprint' => $blueprint->toPublishArray(),
            'fields' => $fields->toPublishArray(),
            'meta' => $fields->meta(),
            'expiry' => $expiry,
            'actions' => [
                'save' => cp_route('memberbox.store'),
            ],
        ];

        if ($request->wantsJson()) {
            return $viewData;
        }

        return view('statamic-memberbox::cp.members.create', $viewData);
    }

    public function store(Request $request)
    {
        $this->authorizePro();
        $this->authorize('mb create members', UserContract::class);

        $blueprint = User::blueprint();

        $only = array_merge(['email'], config('statamic.memberbox.cp_create_fields'));
        $except = ['groups', 'roles', 'password'];

        $fields = $blueprint->fields()->only($only)->except($except)->addValues($request->all());

        $fields->validate(['email' => 'required|email|unique_user_value']);

        $values = $fields->process()->values()->except(['email', 'groups', 'roles', 'password']);

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

        if (config('statamic.memberbox.enable_account', true)) {
            PasswordReset::resetFormRoute('statamic-memberbox.activate');
        } else {
            PasswordReset::resetFormUrl(url(config('statamic.memberbox.routes.activate')));
        }
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
            'redirect' => cp_route('memberbox.edit', $user->id()),
            'activationUrl' => $url,
        ];
    }

    public function edit(Request $request, $user)
    {
        throw_unless($user = User::find($user), new NotFoundHttpException);
        throw_unless(Member::verify($user), new NotFoundHttpException);

        $this->authorize('mb edit members', $user);

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
                'save' => cp_route('memberbox.update', $user->id()),
                'password' => cp_route('users.password.update', $user->id()),
            ],
            'canEditPassword' => User::fromUser($request->user())->can('editPassword', $user),
        ];

        if ($request->wantsJson()) {
            return $viewData;
        }

        return view('statamic-memberbox::cp.members.edit', $viewData);
    }

    public function update(Request $request, $user)
    {
        throw_unless($user = User::find($user), new NotFoundHttpException);
        throw_unless(Member::verify($user), new NotFoundHttpException);

        $this->authorize('mb edit members', $user);

        $fields = $user->blueprint()->fields()->except(['password'])->addValues($request->all());

        $fields->validate(['email' => 'required', new UniqueUserValue($user->id())]);

        $values = $fields->process()->values()->except(['email', 'groups', 'roles']);

        foreach ($values as $key => $value) {
            $user->set($key, $value);
        }
        $user->email($request->email);

        $user->save();

        return ['title' => $user->title()];
    }

    public function export($type)
    {
        $this->authorize('mb view members', UserContract::class);

        $exporter = 'JackSleight\StatamicMemberbox\Exporters\\'.Str::studly($type).'Exporter';

        if (! class_exists($exporter)) {
            throw new FatalException("Exporter of type [$type] does not exist.");
        }

        $exporter = new $exporter;

        $content = $exporter->export();

        if ($this->request->has('download')) {
            $path = storage_path('statamic/tmp/memberbox/members-'.time().'.'.$type);
            File::put($path, $content);
            $response = response()->download($path)->deleteFileAfterSend(true);
        } else {
            $response = response($content)->header('Content-Type', $exporter->contentType());
        }

        return $response;
    }
}
