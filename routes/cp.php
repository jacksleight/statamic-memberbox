<?php

Route::group(['prefix' => 'members'], function () {
    Route::get('', 'CP\UsersController@index')->name('statamic-members.index');
    Route::get('create', 'CP\UsersController@create')->name('statamic-members.create');
    Route::post('store', 'CP\UsersController@store')->name('statamic-members.store');
    Route::get('{user}', 'CP\UsersController@edit')->name('statamic-members.edit');
    Route::patch('{user}', 'CP\UsersController@update')->name('statamic-members.update');
    Route::delete('destroy', 'CP\UsersController@destroy')->name('statamic-members.destroy');
});
