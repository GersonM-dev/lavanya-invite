<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UndanganController;

Route::get('/{undangan:slug}', [UndanganController::class, 'show'])
    ->name('undangan.show');