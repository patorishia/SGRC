<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Marca o endereço de email do utilizador autenticado como verificado.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        // Verifica se o email já foi verificado
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
        }

        // Marca o email como verificado e dispara o evento
        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        // Redireciona para o dashboard após a verificação do email
        return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
    }
}
