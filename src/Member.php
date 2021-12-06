<?php

namespace JackSleight\StatamicMemberbox;

use Statamic\Contracts\Auth\User as UserContract;
use Statamic\Facades\User;
use Statamic\Stache\Query\UserQueryBuilder as StacheUserQueryBuilder;
use Statamic\Stache\Repositories\UserRepository as StacheUserRepository;

class Member
{
    public function isStache()
    {
        return User::getFacadeRoot() instanceof StacheUserRepository;
    }

    public function query($query = null)
    {
        if (! $query) {
            $query = User::query();
        }

        if ($query instanceof StacheUserQueryBuilder) {
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
        } else {
            if ($roles = config('statamic.users.new_user_roles')) {
                foreach ($roles as $role) {
                    $query->whereHas('roles', function ($q) use ($role) {
                        $q->where('role_id', $role);
                    });
                }
            }

            if ($groups = config('statamic.users.new_user_groups')) {
                foreach ($groups as $group) {
                    $query->whereHas('groups', function ($q) use ($group) {
                        $q->where('group_id', $group);
                    });
                }
            }
        }

        return $query;
    }

    public function verify(UserContract $user = null)
    {
        if (! $user) {
            return false;
        }

        if ($roles = config('statamic.users.new_user_roles')) {
            foreach ($roles as $role) {
                if (! $user->hasRole($role)) {
                    return false;
                }
            }
        }

        if ($groups = config('statamic.users.new_user_groups')) {
            foreach ($groups as $group) {
                if (! $user->isInGroup($group)) {
                    return false;
                }
            }
        }

        return true;
    }
}
