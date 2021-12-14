<?php

namespace JackSleight\StatamicMemberbox;

use JackSleight\StatamicMemberbox\Protectors\Member;
use Statamic\Auth\Protect\ProtectorManager;
use Statamic\Facades\CP\Nav;
use Statamic\Facades\Permission;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $routes = [
        'cp'  => __DIR__.'/../routes/cp.php',
        'web' => __DIR__.'/../routes/web.php',
    ];

    protected $scripts = [
        __DIR__.'/../dist/js/addon.js',
    ];

    protected $tags = [
        \JackSleight\StatamicMemberbox\Tags\BaseTag::class,
    ];

    protected $widgets = [
        \JackSleight\StatamicMemberbox\Widgets\Members::class,
    ];

    protected $scopes = [
        \JackSleight\StatamicMemberbox\Scopes\Member::class,
    ];

    public function register()
    {
        parent::register();

        $this->mergeConfigFrom(
            __DIR__.'/../config/statamic/memberbox.php', 'statamic.memberbox',
        );

        $this->app->singleton(Utilities::class, function () {
            return new Utilities();
        });
    }

    public function bootAddon()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'statamic-memberbox');

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'statamic-memberbox');

        $this->publishes([
            __DIR__.'/../config/statamic/memberbox.php' => config_path('statamic/memberbox.php'),
        ], 'statamic-memberbox-config');

        $this->publishes([
            __DIR__.'/../resources/views/web' => resource_path('views/vendor/statamic-memberbox/web'),
        ], 'statamic-memberbox-views');

        Nav::extend(function ($nav) {
            $nav->users('Members')
                ->route('memberbox.index')
                ->active('members')
                ->can('mb view members')
                ->icon('users');
        });

        $this->app->booted(function () {
            Permission::group('mb members', 'Members', function () {
                Permission::register('mb view members')->label(__('statamic-memberbox::permissions.view_members'))->children([
                    Permission::make('mb edit members')->label(__('statamic-memberbox::permissions.edit_members'))->children([
                        Permission::make('mb create members')->label(__('statamic-memberbox::permissions.create_members')),
                    ]),
                ]);
            });
        });

        // app(ProtectorManager::class)->extend('mb_member', function ($app) {
        //     return new Member();
        // });
    }
}
