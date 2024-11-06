<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function sendResetLinkEmail(Request $request)
    {
        // Validar o e-mail
        $request->validate(['email' => 'required|email|exists:users,email']);

        // Enviar o link de redefinição de senha
        $status = Password::sendResetLink($request->only('email'));

        // Retornar uma resposta
        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __('passwords.sent'))
            : back()->withErrors(['email' => __('passwords.user')]);
    }
}
