<?php

use JackSleight\StatamicMemberbox\Http\Controllers\CP\MembersController;

if (config('statamic.memberbox.enable_cp', true)) {
    Route::group(['prefix' => 'memberbox'], function () {
        Route::get('', [MembersController::class, 'index'])->name('memberbox.index');
        Route::get('create', [MembersController::class, 'create'])->name('memberbox.create');
        Route::post('store', [MembersController::class, 'store'])->name('memberbox.store');
        Route::get('{user}', [MembersController::class, 'edit'])->name('memberbox.edit');
        Route::patch('{user}', [MembersController::class, 'update'])->name('memberbox.update');
        Route::delete('destroy', [MembersController::class, 'destroy'])->name('memberbox.destroy');
        Route::get('export/{type}', [MembersController::class, 'export'])->name('memberbox.export');
    });
}
