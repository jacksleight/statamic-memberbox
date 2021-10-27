<?php

namespace JackSleight\StatamicMembers\Tags;

use Statamic\Contracts\Auth\User as UserContract;
use JackSleight\StatamicMembers\Tags\Concerns\AuthorizesMembers;
use Statamic\Tags\Tags;

class NotMemberTags extends Tags
{
    use AuthorizesMembers;

    protected static $handle = 'not_member';

    protected function authorizeMember(UserContract $user = null)
    {
        return !authorize_member($user, $this->params);
    }
}
