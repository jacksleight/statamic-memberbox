<?php
namespace JackSleight\StatamicMembers;

use Statamic\Facades\User;
use Statamic\Contracts\Auth\User as UserContract;
use Statamic\Stache\Query\UserQueryBuilder as StacheUserQueryBuilder;
use Statamic\Stache\Repositories\UserRepository as StacheUserRepository;

class Member
{
    public function isStache()
    {
        return User::getFacadeRoot() instanceof StacheUserRepository;
    }

    public function query()
    {       
        $query = User::query();

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

    public function verify(UserContract $user)
    {       
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

    public function authorize(UserContract $user = null, $params = [])
    {
        $params = collect($params);
    
        if (!$user) {
            return false;
        }
    
        if (!$this->verify($user)) {
            return false;
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
