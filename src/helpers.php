<?php
use Statamic\Contracts\Auth\User as UserContract;

if (!function_exists('member')) {

    function member(UserContract $user = null, $params = []) {

        $params = collect($params);

        if (!$user) {
            return false;
        }

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

        if ($params->has('in') && !$user->isInGroup($params->get('in'))) {
            return false;
        }

        if ($params->has('is') && !$user->hasRole($params->get('is'))) {
            return false;
        }

        if ($params->has('can') && !$user->can($params->get('can'))) {
            return false;
        }

        $ok = true;
        collect($params)->filter(function ($value, $key) {
            return Str::startsWith($key, 'has:');
        })->each(function ($value, $param) use ($user, &$ok) {
            $field = substr($param, 4);
            if ($user->get($field) !== $value) {
                $ok = false;
                return false;
            }
        });
        if (!$ok) {
            return false;
        }

        return true;

    }

}