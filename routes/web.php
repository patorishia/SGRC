<?php

use App\Http\Controllers\ReclamacaoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CondominioController;

Route::get('/', function () {
    return view('welcome');
});


Route::resource('condominio', CondominioController::class);
Route::resource('reclamacao', ReclamacaoController::class);

