<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CondominioController;
use App\Http\Controllers\ReclamacaoController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/reclamacoes/pendentes', [DashboardController::class, 'pendentes'])->name('reclamacoes.pendentes');
Route::get('/reclamacoes/resolvidas', [DashboardController::class, 'resolvidas'])->name('reclamacoes.resolvidas');



    
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rotas para condomínios (CRUD completo)
Route::resource('condominios', CondominioController::class);

// Rotas para reclamações (CRUD completo, apenas autenticadas)
Route::middleware('auth')->group(function () {
    Route::resource('reclamacoes', ReclamacaoController::class);
});



require __DIR__.'/auth.php';

