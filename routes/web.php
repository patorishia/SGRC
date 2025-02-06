<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReclamacaoController;
use App\Http\Controllers\CondominioController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TiposReclamacaoController;
use App\Http\Middleware\SetLocale;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\AdminVerificationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReclamacaoProcessController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FaturaController;
use App\Models\User;

// Rota para página não autorizada
Route::get('/unauthorized', function () {
    return view('unauthorized');
})->name('unauthorized');

// Rota para tratar de erros 404 e 403
Route::fallback(function () {
    return view('unauthorized');
});

// Rotas para gestão de condomínios (acesso restrito a administradores)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/condominios/create', [CondominioController::class, 'create'])->name('condominios.create');
    Route::post('/condominios', [CondominioController::class, 'store'])->name('condominios.store');
    Route::resource('condominios', CondominioController::class);
});

// Rotas protegidas por autenticação
Route::middleware('auth')->group(function () {
    // Rota de perfil de utilizador
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Rota para obter nomes de utilizadores
Route::get('/users/names', function () {
    return User::pluck('name'); // Retorna os nomes dos utilizadores
});

// Rota para obter NIF do utilizador autenticado
Route::get('/user/nif', function () {
    return response()->json(['nif' => auth()->user()->nif]);
});

// Rota para gestão de faturas
Route::resource('faturas', FaturaController::class);
Route::get('/faturas/{id}/edit', [ClienteController::class, 'edit'])->name('faturas.edit');
Route::put('/faturas/{id}', [ClienteController::class, 'update'])->name('faturas.update');
Route::get('/faturas/{id}', [FaturaController::class, 'show'])->name('faturas.show');
Route::middleware('auth')->get('/minhas-faturas', [FaturaController::class, 'minhasFaturas'])->name('faturas.minhas');

// Rota para gestão de clientes
Route::resource('clientes', ClienteController::class);
Route::get('/clientes/{id}/edit', [ClienteController::class, 'edit'])->name('clientes.edit');
Route::put('/clientes/{id}', [ClienteController::class, 'update'])->name('clientes.update');
Route::get('/get-users', [ClienteController::class, 'getUsers']);


// Rota para gestão de produtos
Route::resource('produtos', ProdutoController::class);
Route::get('/produtos', [ProdutoController::class, 'index'])->name('produtos.index');
Route::get('/produtos/create', [ProdutoController::class, 'create'])->name('produtos.create');
Route::get('/produtos/{id}/edit', [ProdutoController::class, 'edit'])->name('produtos.edit');
Route::put('/produtos/{id}', [ProdutoController::class, 'update'])->name('produtos.update');

// Rota para os condomínios do utilizador
Route::get('/meus-condominios', [CondominioController::class, 'meusCondominios'])->name('condominios.meus');

// Rota para as reclamações do utilizador autenticado
Route::middleware('auth')->get('/minhas-reclamacoes', [ReclamacaoController::class, 'minhasReclamacoes'])->name('reclamacoes.minhas');

// Rota para pagamento de uma reclamação
Route::get('/reclamacoes/{id}/pagamento', [ReclamacaoController::class, 'pagamento'])->name('reclamacoes.pagamento');
Route::post('/reclamacoes/{id}/finalizar-pagamento', [ReclamacaoController::class, 'finalizarPagamento'])->name('reclamacoes.finalizarPagamento');

// Rota para o processo de reclamação
Route::post('reclamacoes/{id}/process', [ReclamacaoProcessController::class, 'updateProcess'])->name('reclamacoes.updateProcess');
Route::get('reclamacoes/{reclamacao}/process', [ReclamacaoProcessController::class, 'process'])->name('reclamacoes.process');

// Rota para exportar as reclamações em Excel
Route::get('/reclamacoes/export', [ReclamacaoController::class, 'exportReclamacoesToExcel']);
Route::get('/reclamacoes/export-pdf', [ReclamacaoController::class, 'exportReclamacoesToPDF'])->name('reclamacoes.export-pdf');

// Rota para verificação de administrador
Route::get('/admin/verify/{user}', [AdminVerificationController::class, 'verify'])->name('admin.verify');

// Rota para visualização de faturas
Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');

// Rota para mudar o idioma da aplicação
Route::post('/set-locale', function (Illuminate\Http\Request $request) {
    $locale = $request->input('locale');
    if (in_array($locale, ['en', 'pt', 'fr'])) {
        session(['locale' => $locale]);
        app()->setLocale($locale); // Altera o idioma da aplicação
    }
    return redirect()->back(); // Retorna à página anterior
})->name('set-locale');

// Rota para o formulário de pagamento
Route::get('/payment/form', function () {
    return view('payments.form');
})->name('web.payment.form');

// Rota para obter dados dos utilizadores
Route::get('/users/data', [UserController::class, 'data'])->name('users.data');
Route::get('/users', [UserController::class, 'index'])->name('users.index');

// Aplicando o middleware SetLocale para gerenciar idioma
Route::middleware([SetLocale::class])->group(function () {

    // Rotas para recuperação de senha
    Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    // Rota para tipos de reclamação
    Route::resource('tipos_reclamacao', TiposReclamacaoController::class);

    // Rotas para gestão de condomínios
    Route::get('/condominios', [CondominioController::class, 'index'])->name('condominios.index');
    Route::resource('condominios', CondominioController::class);
    Route::get('/condominios/{id}', [CondominioController::class, 'show'])->name('condominios.show');

    // Rota para o dashboard
    Route::middleware(['auth', 'verified'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rotas de reclamações (somente para utilizadores autenticados e com email verificado)
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::resource('reclamacoes', ReclamacaoController::class);
        Route::get('/reclamacoes/create', [ReclamacaoController::class, 'create'])->name('reclamacoes.create');
        Route::post('/reclamacoes', [ReclamacaoController::class, 'store'])->name('reclamacoes.store');
        Route::get('/reclamacoes/pendentes', [ReclamacaoController::class, 'pendentes'])->name('reclamacoes.pendentes');
        Route::get('/reclamacoes/resolvidas', [ReclamacaoController::class, 'resolvidas'])->name('reclamacoes.resolvidas');
        Route::get('/reclamacoes/export/excel', [ReclamacaoController::class, 'exportReclamacoesToExcel'])->name('reclamacoes.export.excel');
        Route::get('/reclamacoes/export/pdf', [ReclamacaoController::class, 'exportReclamacoesToPDF'])->name('reclamacoes.export.pdf');
    });

    // Rota para gestão de utilizadores (somente para administradores)
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::resource('users', UserController::class);
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::post('/users/{user}/resend-verification', [UserController::class, 'resendVerificationEmail'])->name('users.resendVerificationEmail');
    });

    // Rota para eliminar uma reclamação
    Route::delete('reclamacoes/{id}', [ReclamacaoController::class, 'destroy'])->name('reclamacoes.delete');

    // Rota para a página inicial
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Rotas de autenticação (login e registo)
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    // Rota para verificação de e-mail
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
