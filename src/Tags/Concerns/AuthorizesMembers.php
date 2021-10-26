<?php

namespace JackSleight\StatamicMembers\Tags\Concerns;

use Statamic\Facades\User;
use Statamic\Contracts\Auth\User as UserContract;
use Str;

trait AuthorizesMembers
{
    public function index()
    {
        $user = User::current();

        if ($this->params->has('if') && !$this->params->get('if')) {
            return $this->isPair ? $this->parse() : true;
        }
        
        if (!$this->authorizeMember($user)) {
            return $this->isPair ? null : false;
        }

        return $this->isPair ? $this->parse() : true;
    }

    public function redirect()
    {
        $user = User::current();

        if ($this->params->has('if') && !$this->params->get('if')) {
            return;
        }

        if (!$this->authorizeMember($user)) {
            return;
        }

        return abort(redirect($this->params->get('to', route('statamic.members.login')), $this->params->get('response', 302)));
    }

    public function abort()
    {
        $user = User::current();

        if ($this->params->has('if') && !$this->params->get('if')) {
            return;
        }

        if (!$this->authorizeMember($user)) {
            return;
        }

        return abort($this->params->get('response', 403));
    }

    abstract protected function authorizeMember(UserContract $user = null);
}
