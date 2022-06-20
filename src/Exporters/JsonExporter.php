<?php

namespace JackSleight\StatamicMemberbox\Exporters;

use JackSleight\StatamicMemberbox\Facades\Member;

class JsonExporter
{
    public function export()
    {
        $users = Member::query()->get()->toArray();

        return json_encode($users);
    }

    public function contentType()
    {
        return 'application/json';
    }
}
