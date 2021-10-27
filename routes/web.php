<?php

if ($route = config('statamic.members.routes.login')) {
    Route::statamic($route, 'statamic-members::web.login', [
        'title' => __('statamic-members::messages.login_title'),
    ])->name('statamic.members.login');
}

if ($route = config('statamic.members.routes.forgot')) {
    Route::statamic($route, 'statamic-members::web.forgot', [
        'title' => __('statamic-members::messages.forgot_title'),
    ])->name('statamic.members.forgot');
}

if ($route = config('statamic.members.routes.reset')) {
    Route::statamic($route, 'statamic-members::web.reset', [
        'title' => __('statamic-members::messages.reset_title'),
    ])->name('statamic.members.reset');
}

if ($route = config('statamic.members.routes.activate')) {
    Route::statamic($route . '/{token}', 'statamic-members::web.activate', [
        'title' => __('statamic-members::messages.activate_title'),
    ])->name('statamic.members.activate');
}

if ($route = config('statamic.members.routes.register')) {
    Route::statamic($route, 'statamic-members::web.register', [
        'title' => __('statamic-members::messages.register_title'),
    ])->name('statamic.members.register');
}

if ($route = config('statamic.members.routes.edit')) {
    Route::statamic($route, 'statamic-members::web.edit', [
        'title' => __('statamic-members::messages.edit_title'),
    ])->name('statamic.members.edit');
    Route::post('/!/statamic-members/edit', 'UsersController@edit')->name('statamic.members.edit.action');
}

if ($route = config('statamic.members.routes.password')) {
    Route::statamic($route, 'statamic-members::web.password', [
        'title' => __('statamic-members::messages.password_title'),
    ])->name('statamic.members.password');
    Route::post('/!/statamic-members/password', 'UsersController@password')->name('statamic.members.password.action');
}
