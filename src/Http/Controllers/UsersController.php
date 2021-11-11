<?php

namespace JackSleight\StatamicMemberbox\Http\Controllers;

use Illuminate\Http\Request;
use Statamic\Auth\Passwords\PasswordDefaults;
use Statamic\Facades\User;
use Illuminate\Support\Facades\Validator;
use Statamic\Exceptions\UnauthorizedHttpException;

class UsersController extends Controller
{
    public function profile(Request $request)
    {
        throw_unless($user = User::current(), new UnauthorizedHttpException(403));

        $only = collect(config('statamic.memberbox.profile_fields'));

        $blueprint = User::blueprint();

        $fields = $blueprint->fields()->only($only->all())->addValues($request->all());

        $fieldRules = $fields->validator()->withRules([
            'email' => ['required', 'unique_user_value:'.$user->id()],
        ])->rules();

        $validator = Validator::make($request->all(), $fieldRules);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->withInput()->withErrors($errors, 'statamic-memberbox.user.profile');
        }

        $values = $fields->process()->values()->except(['email', 'groups', 'roles']);

        foreach ($values as $key => $value) {
            $user->set($key, $value);
        }
        if ($only->contains('email')) {
            $user->email($request->email);
        }
        
        $user->save();

        session()->flash('statamic-memberbox.user.profile.success', __('Account updated successfully.'));

        return request()->has('_redirect') ? redirect(request()->get('_redirect')) : back();
    }

    public function changePassword(Request $request)
    {
        throw_unless($user = User::current(), new UnauthorizedHttpException(403));

        $validator = Validator::make($request->all(), [
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'confirmed', PasswordDefaults::rules()],
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->withInput()->withErrors($errors, 'statamic-memberbox.user.change_password');
        }

        $user->password($request->password);

        $user->save();

        session()->flash('statamic-memberbox.user.change_password.success', __('Password changed successfully.'));

        return request()->has('_redirect') ? redirect(request()->get('_redirect')) : back();
    }
}