<?php
use Statamic\Contracts\Auth\User as UserContract;

if (!function_exists('member')) {
    function member(UserContract $user) {
        if ($roles = config('statamic.users.new_user_roles')) {
            foreach ($roles as $role) {
                if (!$user->hasRole($role)) {
                    return false;
                }
            }
        }
        if ($groups = config('statamic.users.new_user_groups')) {
            foreach ($groups as $group) {
                if (!$user->isInGroup($group)) {
                    return false;
                }
            }
        }     
        return true;
    }
}