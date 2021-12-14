<?php

namespace JackSleight\StatamicMemberbox\Tags;

use JackSleight\StatamicMemberbox\Facades\Member;
use Statamic\Tags\Users as UsersTag;

class MembersTags extends UsersTag
{
    public function index()
    {
        return parent::index();
    }

    protected function query()
    {
        $query = Member::query();

        $this->queryConditions($query);
        $this->queryScopes($query);
        $this->queryOrderBys($query);

        return $query;
    }
}
