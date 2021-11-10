<?php
namespace JackSleight\StatamicMembers\Protectors;

use Statamic\Auth\Protect\Protectors\Protector; 
use JackSleight\StatamicMembers\Facades;
use Statamic\Facades\User;

class Member extends Protector
{
    public function protect()
    {
        $user = User::current();
 
        abort_unless(
            Facades\Member::authorize($user),
            redirect(route('statamic.members.login', ['redirect' => url()->current()]))
        );
    }
}