<?php

namespace JackSleight\StatamicMemberbox\Exporters;

use JackSleight\StatamicMemberbox\Facades\Member;
use Statamic\Facades\User;

abstract class AbstractExporter
{
    abstract public function contentType();

    abstract public function export();

    protected function getData()
    {
        return Member::query()->get()
            ->map(function ($user) {
                $data = $user->data();

                return User::blueprint()->fields()->all()->keys()->flip()
                    ->reject(function ($field, $key) {
                        return in_array($key, ['id', 'groups', 'roles', 'password']);
                    })
                    ->map(function ($field, $key) use ($data) {
                        return $data[$key] ?? null;
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
