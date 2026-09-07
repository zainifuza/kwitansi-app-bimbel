<?php

use App\Http\Controllers\KwitansiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('kwitansi.index');
});

Route::get('kwitansi/{kwitansi}/download', [KwitansiController::class, 'download'])
    ->name('kwitansi.download');

Route::resource('kwitansi', KwitansiController::class)->except(['edit', 'update']);
