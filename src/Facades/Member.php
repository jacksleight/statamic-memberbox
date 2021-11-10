<?php

namespace JackSleight\StatamicMemberbox\Facades;

use Illuminate\Support\Facades\Facade;

class Member extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \JackSleight\StatamicMemberbox\Utilities::class;
    }
}