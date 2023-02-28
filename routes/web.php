<?php

Route::name('statamic-memberbox.')->group(function () {
    if (config('statamic.memberbox.enable_account', true)) {
        if ($route = config('statamic.memberbox.routes.activate')) {
            Route::statamic($route.'/{token}', 'statamic-memberbox::web.activate')->name('activate');
        }

        if ($route = config('statamic.memberbox.routes.register')) {
            Route::statamic($route, 'statamic-memberbox::web.register')->name('register');
        }

        if ($route = config('statamic.memberbox.routes.login')) {
            Route::statamic($route, 'statamic-memberbox::web.login')->name('login');
        }

        if ($route = config('statamic.memberbox.routes.profile')) {
            Route::statamic($route, 'statamic-memberbox::web.profile')->name('profile');
            Route::post('/!/statamic-memberbox/profile', 'UsersController@profile')->name('profile.action');
        }

        if ($route = config('statamic.memberbox.routes.forgot_password')) {
            Route::statamic($route, 'statamic-memberbox::web.forgot_password')->name('forgot_password');
        }

        if ($route = config('statamic.memberbox.routes.reset_password')) {
            Route::statamic($route, 'statamic-memberbox::web.reset_password')->name('reset_password');
        }

        if ($route = config('statamic.memberbox.routes.change_password')) {
            Route::statamic($route, 'statamic-memberbox::web.change_password')->name('change_password');
            Route::post('/!/statamic-memberbox/change_password', 'UsersController@changePassword')->name('change_password.action');
        }
    } else {
        if ($route = config('statamic.memberbox.routes.profile')) {
            Route::post('/!/statamic-memberbox/profile', 'UsersController@profile')->name('profile.action');
        }

        if ($route = config('statamic.memberbox.routes.change_password')) {
            Route::post('/!/statamic-memberbox/change_password', 'UsersController@changePassword')->name('change_password.action');
        }
    }
    if (config('statamic.memberbox.enable_directory', false)) {
        if ($route = config('statamic.memberbox.routes.index')) {
            Route::statamic($route, 'statamic-memberbox::web.index')->name('index');
        }

        if ($route = config('statamic.memberbox.routes.show')) {
            Route::statamic($route, 'statamic-memberbox::web.show')->name('show');
        }
    }
});
