<?php

Route::group(['prefix' => config('members.route')], function () {
    
    Route::statamic('login', 'members::web.login')->name('statamic.members.login');
    Route::statamic('forgot', 'members::web.forgot')->name('statamic.members.forgot');
    Route::statamic('reset', 'members::web.reset')->name('statamic.members.reset');
    Route::statamic('activate/{token}', 'members::web.activate')->name('statamic.members.activate');

    if (config('members.enable_register')) {
        Route::statamic('register', 'members::web.register')->name('statamic.members.register');
    }

    if (config('members.enable_edit')) {
        // Route::statamic('edit', 'members::web.edit')->name('members.edit');
        // Route::post('/account/update', [AccountController::class, 'update'])->name('members.update');
    }

});