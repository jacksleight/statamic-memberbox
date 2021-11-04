<?php

namespace JackSleight\StatamicMembers\Facades;

use Illuminate\Support\Facades\Facade;

class Member extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \JackSleight\StatamicMembers\Utilities::class;
    }
}