<?php

Route::name('statamic-memberbox.')->group(function () {
    if ($route = config('statamic.memberbox.routes.activate')) {
        Route::statamic($route.'/{token}', 'statamic-memberbox::web.activate', [
            'title' => __('statamic-memberbox::messages.activate_title'),
        ])->name('activate');
    }

    if ($route = config('statamic.memberbox.routes.register')) {
        Route::statamic($route, 'statamic-memberbox::web.register', [
            'title' => __('statamic-memberbox::messages.register_title'),
        ])->name('register');
    }

    if ($route = config('statamic.memberbox.routes.login')) {
        Route::statamic($route, 'statamic-memberbox::web.login', [
            'title' => __('statamic-memberbox::messages.login_title'),
        ])->name('login');
    }

    if ($route = config('statamic.memberbox.routes.profile')) {
        Route::statamic($route, 'statamic-memberbox::web.profile', [
            'title' => __('statamic-memberbox::messages.profile_title'),
        ])->name('profile');
        Route::post('/!/statamic-memberbox/profile', 'UsersController@profile')->name('profile.action');
    }

    if ($route = config('statamic.memberbox.routes.forgot_password')) {
        Route::statamic($route, 'statamic-memberbox::web.forgot_password', [
            'title' => __('statamic-memberbox::messages.forgot_password_title'),
        ])->name('forgot_password');
    }

    if ($route = config('statamic.memberbox.routes.reset_password')) {
        Route::statamic($route, 'statamic-memberbox::web.reset_password', [
            'title' => __('statamic-memberbox::messages.reset_password_title'),
        ])->name('reset_password');
    }

    if ($route = config('statamic.memberbox.routes.change_password')) {
        Route::statamic($route, 'statamic-memberbox::web.change_password', [
            'title' => __('statamic-memberbox::messages.change_password_title'),
        ])->name('change_password');
        Route::post('/!/statamic-memberbox/change_password', 'UsersController@changePassword')->name('change_password.action');
    }
});
