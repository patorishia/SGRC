<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Condominio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;

class RegisteredUserController extends Controller
{
    /**
     * Exibe a vista de registo.
     */
    public function create(): View
    {
        $condominios = Condominio::all(); // Obtém a lista de condomínios
        return view('auth.register', compact('condominios'));
    }

    /**
     * Processa o pedido de registo de utilizador.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Valida os dados de entrada
        $request->validate([
            'nif' => ['required', 'string', 'max:255', 'unique:users,nif'], 
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'], 
            'telefone' => ['required', 'string', 'max:20', 'unique:users,telefone'],  
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'condominio_id' => 'required|exists:condominio,id',
        ], [
            'nif.unique' => 'Este NIF já está em uso. Por favor, escolha outro.',
            'email.unique' => 'Este email já está em uso. Por favor, escolha outro.',
            'telefone.unique' => 'Este número de telefone já está em uso. Por favor, escolha outro.',
        ]);

        // Cria o novo utilizador
        $user = User::create([
            'nif' => $request->nif,
            'name' => $request->name,
            'email' => $request->email,
            'telefone' => $request->telefone,
            'password' => Hash::make($request->password),
            'condominio_id' => $request->condominio_id,
            'role' => 'user',
        ]);

        // Envia o email de verificação para o administrador
        $this->sendVerificationEmail($user);

        // Faz o login automático do utilizador
        Auth::login($user);

        // Redireciona para a página de verificação de email
        return redirect()->route('verification.notice');
    }

    /**
     * Envia o email de verificação para o administrador.
     */
    public function sendVerificationEmail(User $user)
    {
        // Carrega a relação com o condomínio
        $user->load('condominio');

        // Envia o email
        Mail::send('emails.admin_verification', ['user' => $user], function ($message) use ($user) {
            $message->to('goncalolopes@ipvc.pt');
            $message->subject('Novo Registo de Utilizador');
        });
        Auth::login($user);

        // Redireciona para a página de verificação de email
        return redirect()->route('verification.notice');
    }
}
