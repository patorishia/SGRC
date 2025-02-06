<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Atualiza a palavra-passe do utilizador.
     */
    public function update(Request $request): RedirectResponse
    {
        // Validação dos dados de entrada para atualização da palavra-passe
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'], // Palavra-passe atual obrigatória e verificada
            'password' => ['required', Password::defaults(), 'confirmed'], // Nova palavra-passe obrigatória, com regras padrão e confirmação
        ]);

        // Atualiza a palavra-passe do utilizador no sistema
        $request->user()->update([
            'password' => Hash::make($validated['password']), // Aplica o hash à nova palavra-passe
        ]);

        // Redireciona de volta com uma mensagem de sucesso
        return back()->with('status', 'password-updated');
    }
}
