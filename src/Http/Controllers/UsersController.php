<?php

namespace JackSleight\StatamicMembers\Http\Controllers;

use Illuminate\Http\Request;
use Statamic\Auth\Passwords\PasswordDefaults;

class UsersController extends Controller
{
    public function update(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'name'             => ['sometimes'],
            'email'            => ['required', 'unique_user_value:'.$user->id()],
            'current_password' => ['required_with:password', 'current_password'],
            'password'         => ['sometimes', 'confirmed', $request->filled('password') ? PasswordDefaults::rules() : null],
        ]);

        if ($request->filled('password')) {
            $user->password($validated['password']);
        }
        $user->save();

        return redirect()->back()->with('success', 'Your account has been updated!');
    }
}