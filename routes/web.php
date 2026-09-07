<?php

use App\Http\Controllers\KwitansiController;
use App\Http\Controllers\CompanySettingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('kwitansi.index');
});

Route::get('kwitansi/{kwitansi}/download', [KwitansiController::class, 'download'])
    ->name('kwitansi.download');

Route::resource('kwitansi', KwitansiController::class)->except(['edit', 'update']);

Route::get('pengaturan/kwitansi', [CompanySettingController::class, 'edit'])
    ->name('settings.company.edit');
Route::put('pengaturan/kwitansi', [CompanySettingController::class, 'update'])
    ->name('settings.company.update');
