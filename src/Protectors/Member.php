<?php

namespace JackSleight\StatamicMemberbox\Protectors;

use JackSleight\StatamicMemberbox\Facades;
use Statamic\Auth\Protect\Protectors\Protector;
use Statamic\Facades\User;

class Member extends Protector
{
    public function protect()
    {
        $user = User::current();

        $params = ['redirect' => url()->current()];
        $url = config('statamic.memberbox.enable_account')
            ? route('statamic-memberbox.login', $params)
            : url(config('statamic.memberbox.routes.login').'?'.Arr::query($params));

        abort_unless(Facades\Member::authorize($user), $url);
    }
}
