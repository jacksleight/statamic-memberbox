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
            ->except(['id', 'groups', 'roles', 'password'])
            ->all()
            ->keys()
            ->merge(['id', 'last_login'])
            ->merge(User::getComputedCallbacks()->keys())
            ->all();
    }

    protected function getData()
    {
        return Member::query()->get()
            ->map(function ($user) {
                $data = $user->data();
                $computedData = $user->computedData();

                return collect($this->getKeys())
                    ->flip()
                    ->map(function ($field, $key) use ($data, $computedData) {
                        return $data[$key] ?? $computedData[$key] ?? null;
                    })
                    ->merge([
                        'id' => $user->id(),
                        'last_login' => $user->lastLogin(),
                    ])
                    ->all();
            })
            ->all();
    }
}
