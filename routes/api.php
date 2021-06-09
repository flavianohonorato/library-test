<?php

use App\Http\Controllers\AuthorStoreController;
use App\Http\Controllers\HealthCheckController;
use Illuminate\Support\Facades\Route;

Route::post('/authors', AuthorStoreController::class);

Route::get('.health', HealthCheckController::class);
