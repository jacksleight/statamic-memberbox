<?php

namespace JackSleight\StatamicMemberbox\Scopes;

use JackSleight\StatamicMemberbox\Facades;
use Statamic\Query\Scopes\Scope;

class Member extends Scope
{
    protected static $handle = 'mb_member';

    public function apply($query, $values)
    {
        Facades\Member::query($query);
    }
}
