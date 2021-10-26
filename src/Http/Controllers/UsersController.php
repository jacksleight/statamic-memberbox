<?php

namespace JackSleight\StatamicMembers\Http\Controllers;

use Illuminate\Http\Request;
use Statamic\Auth\Passwords\PasswordDefaults;
use Statamic\Facades\User;
use Illuminate\Support\Facades\Validator;
use Statamic\Exceptions\UnauthorizedHttpException;

class UsersController extends Controller
{
    public function edit(Request $request)
    {
        throw_unless($user = User::current(), new UnauthorizedHttpException(403));

        $fillable = collect(config('statamic.members.fillable'));

        $blueprint = User::blueprint();

        $fields = $blueprint->fields()->only($fillable->all())->addValues($request->all());

        $fieldRules = $fields->validator()->withRules([
            'email' => ['required', 'unique_user_value:'.$user->id()],
        ])->rules();

        $validator = Validator::make($request->all(), $fieldRules);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->withInput()->withErrors($errors, 'member.edit');
        }
                
        $values = $fields->process()->values()->except(['email', 'groups', 'roles']);
        
        if ($fillable->contains('email')) {
            $user->email($request->email);
        }
        
        $user->merge($values);

        $user->save();

        session()->flash('member.edit.success', __('Account updated successfully.'));

        return request()->has('_redirect') ? redirect(request()->get('_redirect')) : back();
    }

    public function password(Request $request)
    {
        throw_unless($user = User::current(), new UnauthorizedHttpException(403));

        $validator = Validator::make($request->all(), [
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'confirmed', PasswordDefaults::rules()],
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->withInput()->withErrors($errors, 'member.password');
        }
                        
        $user->password($request->password);

        $user->save();

        session()->flash('member.password.success', __('Password changed successfully.'));

        return request()->has('_redirect') ? redirect(request()->get('_redirect')) : back();
    }
}