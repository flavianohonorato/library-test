<?php

use App\Http\Controllers\AuthorStoreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/authors', AuthorStoreController::class);
