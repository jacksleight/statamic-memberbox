<?php

namespace JackSleight\StatamicMembers;

use Statamic\Providers\AddonServiceProvider;
use Statamic\Facades\CP\Nav;
use Statamic\Facades\Permission;
use JackSleight\StatamicMembers\Member;

class ServiceProvider extends AddonServiceProvider
{
    protected $routes = [
        'cp'  => __DIR__.'/../routes/cp.php',
        'web' => __DIR__.'/../routes/web.php',
    ];

    protected $scripts = [
        __DIR__ . '/../dist/js/addon.js',
    ];

    protected $tags = [
        \JackSleight\StatamicMembers\Tags\MemberTags::class,
        \JackSleight\StatamicMembers\Tags\NotMemberTags::class,
    ];

    public function register()
    {
        parent::register();

        $this->mergeConfigFrom(
            __DIR__ . '/../config/statamic/members.php', 'statamic.members',
        );

        $this->app->singleton(Member::class, function () {
            return new Member();
        });
    }

    public function boot()
    {
        parent::boot();

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'statamic-members');

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'statamic-members');

        $this->publishes([
            __DIR__ . '/../config/statamic/members.php' => config_path('statamic/members.php'),
        ], 'statamic-members-config');

        $this->publishes([
            __DIR__.'/../resources/views/web' => resource_path('views/vendor/statamic-members/web'),
        ], 'statamic-members-views');

        Nav::extend(function ($nav) {
            $nav->create('Members')
                ->section('Members')
                ->route('statamic-members.index')
                ->active('members')
                ->can('view members')
                ->icon('users');
        });

        $this->app->booted(function () {
            Permission::group('members', 'Members', function () {
                Permission::register('view members')->label(__('statamic-members::permissions.view_members'))->children([
                    Permission::make('edit members')->label(__('statamic-members::permissions.edit_members'))->children([
                        Permission::make('create members')->label(__('statamic-members::permissions.create_members')),
                    ]),
                ]);
            });
        });
    }
}