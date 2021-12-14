<?php

namespace JackSleight\StatamicMemberbox\Tags;

use JackSleight\StatamicMemberbox\Facades\Member;
use Statamic\Auth\UserTags;
use Statamic\View\Antlers\AntlersString;

class MemberTags extends UserTags
{
    public function index()
    {
        $user = parent::index();

        if ($user instanceof AntlersString) {
            return $user;
        }

        if (! Member::verify($user)) {
            return $this->parseNoResults();
        }

        return $user;
    }
}
