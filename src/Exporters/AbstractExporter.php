<?php

namespace JackSleight\StatamicMemberbox\Exporters;

use JackSleight\StatamicMemberbox\Facades\Member;
use Statamic\Facades\User;

abstract class AbstractExporter
{
    abstract public function contentType();

    abstract public function export();

    protected function getKeys()
    {
        return User::blueprint()
            ->fields()
            ->except(['groups', 'roles'])
            ->all()
            ->keys()
            ->merge(User::getComputedCallbacks()->keys())
            ->merge(['id', 'last_login'])
            ->reject('password')
            ->all();
    }

    protected function getData()
    {
        return Member::query()->get()
            ->map(function ($user) {
                $data = $user->data()
                    ->merge($user->computedData())
                    ->merge([
                        'id' => $user->id(),
                        'email' => $user->email(),
                        'last_login' => $user->lastLogin(),
                    ]);

                return collect($this->getKeys())
                    ->flip()
                    ->map(fn ($field, $key) => $data->get($key))
                    ->all();
            })
            ->all();
    }
}
