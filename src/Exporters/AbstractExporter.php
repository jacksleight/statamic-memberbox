<?php

namespace JackSleight\StatamicMemberbox\Exporters;

use JackSleight\StatamicMemberbox\Facades\Member;
use Statamic\Facades\User;
use Statamic\Support\Arr;

abstract class AbstractExporter
{
    protected function getHeaders()
    {
        return User::blueprint()
            ->fields()
            ->except(['groups', 'roles', 'password'])
            ->all()
            ->keys()
            ->merge(['id', 'last_login'])
            ->all();
    }

    protected function getData()
    {
        $headers = $this->getHeaders();
        $default = array_combine($headers, array_fill(0, count($headers), null));

        $users = Member::query()->get()->toArray();

        return collect($users)
            ->map(function ($user) use ($headers, $default) {
                return array_merge($default, Arr::only($user, $headers));
            })
            ->map(function ($user) {
                return collect($user)->map(function ($value) {
                    return (is_array($value)) ? implode(', ', $value) : $value;
                })->all();
            })
            ->all();
    }
}
