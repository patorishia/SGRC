<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserVerifiedMail;

class AdminVerificationController extends Controller
{
    public function verify(User $user)
    {
        // Marca o utilizador como verificado
        $user->email_verified_at = now();
        $user->save();

        // Envia o email de sucesso de verificação para o utilizador
        Mail::to($user->email)->send(new UserVerifiedMail($user));

        // Retorna uma mensagem de sucesso
        return view('admin.verification_success');
    }
}
