<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReclamacaoController;
use App\Http\Controllers\CondominioController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CondominoController;
use App\Http\Controllers\TiposReclamacaoController;

Route::resource('tipos_reclamacao', TiposReclamacaoController::class);


Route::get('/condominios', [CondominioController::class, 'index'])->name('condominios.index');
Route::resource('condominios', CondominioController::class);
Route::get('/condominios/{id}', [CondominioController::class, 'show'])->name('condominios.show');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard'); // Mantenha esta

Route::get('/reclamacoes/pendentes', [ReclamacaoController::class, 'pendentes'])->name('reclamacoes.pendentes');
Route::get('/reclamacoes/resolvidas', [ReclamacaoController::class, 'resolvidas'])->name('reclamacoes.resolvidas');

Route::middleware(['auth'])->group(function () {
    Route::resource('reclamacoes', ReclamacaoController::class);
});
Route::get('/reclamacoes/create', [ReclamacaoController::class, 'create'])->name('reclamacoes.create');
Route::post('/reclamacoes', [ReclamacaoController::class, 'store'])->name('reclamacoes.store');


// Rota para listar todos os condomínios// Rota para listar condominos
Route::get('/gerente', [CondominoController::class, 'index'])->name('gerente.index');

Route::resource('condominos', CondominoController::class);


// Rota para mostrar o formulário de criação de condomínios
Route::get('/gerente/create', [CondominoController::class, 'create'])->name('gerente.create');
Route::get('/gerente/{id}', [CondominoController::class, 'show'])->name('gerente.show');
Route::put('/gerente/{id}', [CondominoController::class, 'update'])->name('gerente.update');



// Rota para armazenar o novo condomínio
Route::post('/gerente', [CondominoController::class, 'store'])->name('gerente.store');

// Rota para a home page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Rotas de autenticação (login e registro)
Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('login', [AuthenticatedSessionController::class, 'store']);
Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('register', [RegisteredUserController::class, 'store']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
