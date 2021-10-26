<?php

namespace JackSleight\StatamicMembers\Tags\Concerns;

use Statamic\Facades\User;
use Statamic\Contracts\Auth\User as UserContract;
use Str;

trait AuthorizesMembers
{
    public function __call($method, $args)
    {
        $user = User::current();

        if ($this->params->has('if') && !$this->params->get('if')) {
            return $this->parse($user);
        }

        if (!$this->checkMember($user)) {
            return;
        }

        return $this->parse($user);
    }

    public function redirect()
    {
        $user = User::current();

        if ($this->params->has('if') && !$this->params->get('if')) {
            return;
        }

        if (!$this->checkMember($user)) {
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

        if (!$this->checkMember($user)) {
            return;
        }

        return abort($this->params->get('response', 403));
    }

    abstract protected function checkMember(UserContract $user);

    protected function authorizeMember(UserContract $user)
    {
        if (!member($user)) {
            return false;
        }

        if ($this->params->has('in') && !$user->isInGroup($this->params->get('in'))) {
            return false;
        }

        if ($this->params->has('is') && !$user->hasRole($this->params->get('is'))) {
            return false;
        }

        if ($this->params->has('can') && !$user->can($this->params->get('can'))) {
            return false;
        }

        $ok = true;
        collect($this->params)->filter(function ($value, $key) {
            return Str::startsWith($key, 'has:');
        })->each(function ($value, $param) use ($user, &$ok) {
            $field = substr($param, 4);
            if ($user->get($field) !== $value) {
                $ok = false;
                return false;
            }
        });
        if (!$ok) {
            return false;
        }

        return $ok;
    }
}
