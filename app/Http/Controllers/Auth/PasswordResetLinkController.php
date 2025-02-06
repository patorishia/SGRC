<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Exibe a vista para solicitar o link de recuperação de palavra-passe.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Processa o pedido de envio do link para recuperação de palavra-passe.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Valida o email fornecido pelo utilizador
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Envia o link para recuperação de palavra-passe
        $status = Password::sendResetLink(
            $request->only('email')
        );

        // Retorna a resposta adequada dependendo do resultado do envio
        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);
    }
}
