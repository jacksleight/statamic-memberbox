<?php

Route::group(['prefix' => 'memberbox'], function () {
    Route::get('', 'CP\MembersController@index')->name('memberbox.index');
    Route::get('create', 'CP\MembersController@create')->name('memberbox.create');
    Route::post('store', 'CP\MembersController@store')->name('memberbox.store');
    Route::get('{user}', 'CP\MembersController@edit')->name('memberbox.edit');
    Route::patch('{user}', 'CP\MembersController@update')->name('memberbox.update');
    Route::delete('destroy', 'CP\MembersController@destroy')->name('memberbox.destroy');
});
