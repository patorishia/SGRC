<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * Enviar o e-mail de redefinição de palavra-passe.
     */
    public function sendResetLinkEmail(Request $request)
    {
        // Validar o e-mail fornecido.
        $request->validate(['email' => 'required|email|exists:users,email']);

        // Enviar o link de redefinição de palavra-passe.
        $status = Password::sendResetLink($request->only('email'));

        // Retornar uma resposta conforme o status do envio.
        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __('passwords.sent'))
            : back()->withErrors(['email' => __('passwords.user')]);
    }
}
