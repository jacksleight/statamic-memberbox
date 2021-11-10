<?php

namespace JackSleight\StatamicMemberbox\Tags;

use JackSleight\StatamicMemberbox\Facades\Member;
use Statamic\Facades\User;

class MemberTags extends SubTag
{
    public function index()
    {
        $user = User::current();
        
        return Member::authorize($user, $this->params);
    }
}
