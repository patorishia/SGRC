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

Route::middleware('auth')->group(function () {
    // Rotas para reclamações e exportação
    Route::resource('reclamacoes', ReclamacaoController::class);
    Route::get('/reclamacoes/export/excel', [ReclamacaoController::class, 'exportReclamacoesToExcel'])->name('reclamacoes.export.excel');
    Route::get('/reclamacoes/export/pdf', [ReclamacaoController::class, 'exportReclamacoesToPDF'])->name('reclamacoes.export.pdf');
});



require __DIR__.'/auth.php';

