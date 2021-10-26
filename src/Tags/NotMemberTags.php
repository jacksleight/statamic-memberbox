<?php

namespace JackSleight\StatamicMembers\Tags;

use Statamic\Contracts\Auth\User as UserContract;
use JackSleight\StatamicMembers\Tags\Concerns\AuthorizesMembers;
use Statamic\Tags\Tags;

class NotMemberTags extends Tags
{
    use AuthorizesMembers;

    protected static $handle = 'not_member';

    protected function checkMember(UserContract $user)
    {
        return !$user || !$this->authorizeMember($user);
    }
}
