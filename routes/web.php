<?php

Route::group(['prefix' => config('statamic.members.route')], function () {
    
    Route::statamic('login', 'members::web.login', [
        'title' => __('members::messages.login_title'),
    ])->name('statamic.members.login');
    Route::statamic('forgot', 'members::web.forgot', [
        'title' => __('members::messages.forgot_title'),
    ])->name('statamic.members.forgot');
    Route::statamic('reset', 'members::web.reset', [
        'title' => __('members::messages.reset_title'),
    ])->name('statamic.members.reset');
    Route::statamic('activate/{token}', 'members::web.activate', [
        'title' => __('members::messages.activate_title'),
    ])->name('statamic.members.activate');

    if (config('statamic.members.enable_register')) {
        Route::statamic('register', 'members::web.register', [
            'title' => __('members::messages.register_title'),
        ])->name('statamic.members.register');
    }

    if (config('statamic.members.enable_edit')) {
        Route::statamic('edit', 'members::web.edit', [
            'title' => __('members::messages.edit_title'),
        ])->name('statamic.members.edit');
        Route::post('edit/action', 'UsersController@edit')->name('statamic.members.edit.action');
    }

    if (config('statamic.members.enable_password')) {
        Route::statamic('password', 'members::web.password', [
            'title' => __('members::messages.password_title'),
        ])->name('statamic.members.password');
        Route::post('password/action', 'UsersController@password')->name('statamic.members.password.action');
    }
    
});