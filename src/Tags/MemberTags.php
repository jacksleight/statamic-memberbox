<?php

namespace JackSleight\StatamicMemberbox\Tags;

use JackSleight\StatamicMemberbox\Facades\Member;
use Statamic\Auth\UserTags;
use Statamic\Facades\User;

class MemberTags extends UserTags
{
    public function wildcard(string $name)
    {
        if (! $user = $this->getUser()) {
            return $this->parseNoResults();
        }

        return $user->augmentedValue($name);
    }

    public function index()
    {
        if (! $user = $this->getUser()) {
            return $this->parseNoResults();
        }

        return $user;
    }

    protected function getUser()
    {
        $user = null;

        // Get a user by ID, if the `id` parameter was used.
        if ($id = $this->params->get('id')) {
            if (! $user = User::find($id)) {
                return null;
            }
        }

        // Get a user by email, if the `email` parameter was used.
        if ($email = $this->params->get('email')) {
            if (! $user = User::findByEmail($email)) {
                return null;
            }
        }

        // Get a user by field, if the `field` parameter was used.
        if ($field = $this->params->get('field')) {
            if (! $user = User::query()->where($field, $this->params->get('value'))->first()) {
                return null;
            }
        }

        // No user found? Get the current one.
        if (! $user) {
            if (! $user = User::current()) {
                return null;
            }
        }

        if (! Member::verify($user)) {
            return null;
        }

        return $user;
    }
}
