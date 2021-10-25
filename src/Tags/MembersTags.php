<?php

namespace JackSleight\StatamicMembers\Tags;

use Statamic\Facades\URL;
use Statamic\Facades\User;
use Statamic\Fields\Field;
use Statamic\Support\Arr;
use Statamic\Tags\Concerns;
use Statamic\Tags\Tags;
use Str;

class MembersTags extends Tags
{
    protected static $handle = 'members';

    public function __call($method, $args)
    {
        if (!$this->authoriseMember()) {
            return;
        }

        return $this->parse();
    }

    public function not()
    {
        if ($this->authoriseMember()) {
            return;
        }

        return $this->parse();
    }

    public function page()
    {
        if (!$this->authoriseMember()) {
            abort(redirect(route('statamic.members.login')));
        }

        return;
    }

    protected function authoriseMember()
    {
        if ($this->params->has('if') && !$this->params->get('if')) {
            return true;
        }

        if (!$user = User::current()) {
            return false;
        }

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
