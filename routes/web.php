<?php

Route::group(['prefix' => config('statamic.members.route')], function () {
    
    Route::statamic('login', 'statamic-members::web.login', [
        'title' => __('statamic-members::messages.login_title'),
    ])->name('statamic.members.login');
    Route::statamic('forgot', 'statamic-members::web.forgot', [
        'title' => __('statamic-members::messages.forgot_title'),
    ])->name('statamic.members.forgot');
    Route::statamic('reset', 'statamic-members::web.reset', [
        'title' => __('statamic-members::messages.reset_title'),
    ])->name('statamic.members.reset');
    Route::statamic('activate/{token}', 'statamic-members::web.activate', [
        'title' => __('statamic-members::messages.activate_title'),
    ])->name('statamic.members.activate');

    if (config('statamic.members.enable_register')) {
        Route::statamic('register', 'statamic-members::web.register', [
            'title' => __('statamic-members::messages.register_title'),
        ])->name('statamic.members.register');
    }

    if (config('statamic.members.enable_edit')) {
        Route::statamic('edit', 'statamic-members::web.edit', [
            'title' => __('statamic-members::messages.edit_title'),
        ])->name('statamic.members.edit');
        Route::post('edit/action', 'UsersController@edit')->name('statamic.members.edit.action');
    }

    if (config('statamic.members.enable_password')) {
        Route::statamic('password', 'statamic-members::web.password', [
            'title' => __('statamic-members::messages.password_title'),
        ])->name('statamic.members.password');
        Route::post('password/action', 'UsersController@password')->name('statamic.members.password.action');
    }
    
});