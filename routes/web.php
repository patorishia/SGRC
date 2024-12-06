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
use App\Http\Middleware\SetLocale;



// Rota para mudar o idioma
Route::post('/set-locale', function (Illuminate\Http\Request $request) {
    $locale = $request->input('locale');
    if (in_array($locale, ['en', 'pt'])) {
        session(['locale' => $locale]);
        app()->setLocale($locale); // Alterar o idioma da aplicação
    }
    return redirect()->back(); // Retorna para a página anterior
})->name('set-locale');





//Rota para o Formulário de pagamento
Route::get('/payment/form', function () {
    return view('payments.form');
})->name('web.payment.form');




// Aqui estamos aplicando o middleware SetLocale
Route::middleware([SetLocale::class])->group(function () {

    // Rotas de senha
    Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    // Rota de tipos de reclamação
    Route::resource('tipos_reclamacao', TiposReclamacaoController::class);

    // Rotas de condomínios
    Route::get('/condominios', [CondominioController::class, 'index'])->name('condominios.index');
    Route::resource('condominios', CondominioController::class);
    Route::get('/condominios/{id}', [CondominioController::class, 'show'])->name('condominios.show');

    // Rota para o dashboard
    Route::middleware(['auth', 'verified'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rotas de reclamações (acesso restrito a usuários autenticados e com email verificado)
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::resource('reclamacoes', ReclamacaoController::class);
        Route::get('/reclamacoes/create', [ReclamacaoController::class, 'create'])->name('reclamacoes.create');
        Route::post('/reclamacoes', [ReclamacaoController::class, 'store'])->name('reclamacoes.store');
        Route::get('/reclamacoes/pendentes', [ReclamacaoController::class, 'pendentes'])->name('reclamacoes.pendentes');
        Route::get('/reclamacoes/resolvidas', [ReclamacaoController::class, 'resolvidas'])->name('reclamacoes.resolvidas');
        Route::get('/reclamacoes/export/excel', [ReclamacaoController::class, 'exportReclamacoesToExcel'])->name('reclamacoes.export.excel');
        Route::get('/reclamacoes/export/pdf', [ReclamacaoController::class, 'exportReclamacoesToPDF'])->name('reclamacoes.export.pdf');
    });

    // Rota para listar todos os condomínios e gerenciar condomínios
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/gerente', [CondominoController::class, 'index'])->name('gerente.index');
        Route::resource('condominos', CondominoController::class);
        Route::get('/gerente/create', [CondominoController::class, 'create'])->name('gerente.create');
        Route::get('/gerente/{nif}', [CondominoController::class, 'show'])->name('gerente.show');
        Route::put('/gerente/{nif}', [CondominoController::class, 'update'])->name('gerente.update');
        Route::post('/gerente', [CondominoController::class, 'store'])->name('gerente.store');
    });

    // Rota para a home page
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Rotas de autenticação (login e registro)
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    // Rota de verificação de e-mail
    Route::get('email/verify', function () {
        return view('auth.verify');
    })->name('verification.notice');

    // Rota para enviar novamente o e-mail de verificação
    Route::get('email/resend', function () {
        auth()->user()->sendEmailVerificationNotification();
        return back()->with('status', 'Verification link sent!');
    })->name('verification.resend');

    // Rotas protegidas por autenticação
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

});

require __DIR__ . '/auth.php';
