<?php

Route::group(['prefix' => config('statamic.members.route')], function () {
    
    Route::statamic('login', 'members::web.login')->name('statamic.members.login');
    Route::statamic('forgot', 'members::web.forgot')->name('statamic.members.forgot');
    Route::statamic('reset', 'members::web.reset')->name('statamic.members.reset');
    Route::statamic('activate/{token}', 'members::web.activate')->name('statamic.members.activate');

    if (config('statamic.members.enable_register')) {
        Route::statamic('register', 'members::web.register')->name('statamic.members.register');
    }

    if (config('statamic.members.enable_edit')) {
        Route::statamic('edit', 'members::web.edit')->name('statamic.members.edit');
        Route::post('edit/action', 'UsersController@edit')->name('statamic.members.edit.action');
    }

    if (config('statamic.members.enable_password')) {
        Route::statamic('password', 'members::web.password')->name('statamic.members.password');
        Route::post('password/action', 'UsersController@password')->name('statamic.members.password.action');
    }
    
});