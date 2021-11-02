<?php

namespace JackSleight\StatamicMembers\Tags;

use Statamic\Contracts\Auth\User as UserContract;
use JackSleight\StatamicMembers\Tags\Concerns\AuthorizesMembers;
use JackSleight\StatamicMembers\Facades\Member;
use Statamic\Tags\Tags;

class NotMemberTags extends Tags
{
    use AuthorizesMembers;

    protected static $handle = 'not_member';

    protected function authorizeMember(UserContract $user = null)
    {
        return !Member::authorize($user, $this->params);
    }
}
