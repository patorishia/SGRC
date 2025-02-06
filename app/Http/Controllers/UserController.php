<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Condominio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Exibe todos os utilizadores e condomínios.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $currentUser = auth()->user();

        // Verifica se o utilizador é administrador ou gerente de pelo menos um condomínio
        $isManager = Condominio::where('manager_id', $currentUser->id)->exists();

        if ($currentUser->role !== 'admin' && !$isManager) {
            return redirect()->route('unauthorized'); 
        }

        // Obtém todos os utilizadores e condomínios
        $users = User::all();
        $condominios = Condominio::all();

        // Retorna a vista com os utilizadores e condomínios
        return view('users.index', compact('users', 'condominios'));
    }

    /**
     * Exibe o formulário para criar um novo utilizador.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $user = auth()->user();

        
        if ($user->role !== 'admin' && !Condominio::where('manager_id', $user->id)->exists()) {
            return redirect()->route('unauthorized'); // Redireciona se o utilizador não estiver autorizado
        }

        $condominios = Condominio::all();

        // Retorna a vista com o formulário de criação de utilizador
        return view('users.create', compact('condominios'));
    }

    /**
     * Armazena um novo utilizador.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Valida os dados do formulário e cria um novo utilizador
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'telefone' => 'required|string|max:15',
            'role' => 'required|string|in:user,admin',
            'nif' => 'required|string|max:20|unique:users,nif', 
            'condominio_id' => 'required|exists:condominio,id', 
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'telefone' => $request->telefone,
            'role' => $request->role,
            'nif' => $request->nif,  
            'condominio_id' => $request->condominio_id, 
            'password' => bcrypt($request->password),
        ]);

        // Redireciona para a lista de utilizadores com uma mensagem de sucesso
        return redirect()->route('users.index')->with('success', __('Condómino criado com sucesso!'));
    }

    /**
     * Exibe os detalhes de um utilizador específico.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\View\View
     */
    public function show(User $user)
    {
        $currentUser = auth()->user();

       
        if ($currentUser->role !== 'admin' && !Condominio::where('manager_id', $currentUser->id)->where('id', $user->condominio_id)->exists()) {
            return redirect()->route('unauthorized'); 
        }

        $condominio = $user->condominio; // Obtém o condomínio relacionado ao utilizador
        return view('users.show', compact('user', 'condominio'));
    }

    /**
     * Exibe o formulário para editar um utilizador existente.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        // Verifica se o utilizador é administrador
        if (auth()->check() && auth()->user()->role !== 'admin') {
            return redirect()->route('unauthorized'); 
        }

        // Obtém todos os condomínios
        $condominios = Condominio::all();
        return view('users.edit', compact('user', 'condominios'));
    }

    /**
     * Atualiza os dados de um utilizador existente.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Valida os dados do formulário
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'telefone' => 'required|string|max:20',
            'role' => 'required|in:user,admin',
            'condominio_id' => 'required|exists:condominio,id',
        ]);

        // Atualiza os dados do utilizador
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'telefone' => $request->telefone,
            'role' => $request->role,
            'condominio_id' => $request->condominio_id,
        ]);

        // Redireciona para a lista de utilizadores com uma mensagem de sucesso
        return redirect()->route('users.index')->with('success', __('Condómino atualizado com sucesso!'));
    }

    /**
     * Retorna os dados dos utilizadores em formato JSON.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data()
    {
        return datatables(User::with('condominio')->select('users.*'))->make(true);
    }

    /**
     * Apaga um utilizador existente.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Verifica se o utilizador é o gerente de algum condomínio
        $isManager = Condominio::where('manager_id', $user->id)->exists();

        // Verifica se o utilizador tem reclamações associadas
        $hasReclamacao = $user->reclamacoes()->exists();

        if ($isManager) {
            // Se o utilizador for gerente, retorna com a mensagem de erro
            return redirect()->route('users.show', $id)
                             ->with('error', __('Este condómino não pode ser apagado, pois é o gerente de um condomínio.'));
        }

        if ($hasReclamacao) {
            // Se o utilizador tiver reclamações, retorna com a mensagem de erro
            return redirect()->route('users.show', $id)
                             ->with('error', __('Este condómino não pode ser apagado, pois tem uma reclamação associada.'));
        }

        // Caso contrário, apaga o utilizador
        $user->delete();

        // Redireciona para a lista de utilizadores com a mensagem de sucesso
        return redirect()->route('users.index')
                         ->with('success', __('Condómino apagado com sucesso.'));
    }

    /**
     * Reenvia o e-mail de verificação ao administrador.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $userId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resendVerificationEmail(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        // Verifica se o utilizador já está verificado
        if ($user->hasVerifiedEmail()) {
            return redirect()->route('users.show', $userId)->with('success', __('Este Condomino já está verificado'));
        }

        // Envia o e-mail de verificação para o administrador
        Mail::send('emails.admin_verification', ['user' => $user], function ($message) use ($user) {
            $message->to('goncalolopes@ipvc.pt');
            $message->subject(__('New User Registration'));
        });

        // Retorna a página de detalhes do utilizador com uma mensagem de sucesso
        return redirect()->route('users.show', $userId)->with('success', __('Email de verificação reenviado ao administrador.'));
    }

    /**
     * Obtém todos os utilizadores em formato JSON.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUsers()
    {
        // Obtém todos os utilizadores da tabela 'users'
        $users = User::all();

        // Retorna os utilizadores em formato JSON
        return response()->json($users);
    }

   
}
