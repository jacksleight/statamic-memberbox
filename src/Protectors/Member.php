<?php
namespace JackSleight\StatamicMemberbox\Protectors;

use Statamic\Auth\Protect\Protectors\Protector; 
use JackSleight\StatamicMemberbox\Facades;
use Statamic\Facades\User;

class Member extends Protector
{
    public function protect()
    {
        $user = User::current();
 
        abort_unless(
            Facades\Member::authorize($user),
            redirect(route('statamic-memberbox.login', ['redirect' => url()->current()]))
        );
    }
}