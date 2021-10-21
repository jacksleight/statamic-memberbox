<?php

Route::group(['prefix' => 'members'], function () {
    Route::get('', 'CP\UsersController@index')->name('members.index');
    Route::get('create', 'CP\UsersController@create')->name('members.create');
    Route::post('store', 'CP\UsersController@store')->name('members.store');
    Route::get('{user}', 'CP\UsersController@edit')->name('members.edit');
    Route::patch('{user}', 'CP\UsersController@update')->name('members.update');
    Route::delete('destroy', 'CP\UsersController@destroy')->name('members.destroy');
});
