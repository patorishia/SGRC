<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CondominioController;

Route::get('/', function () {
    return view('welcome');
});


Route::resource('condominio', CondominioController::class);
