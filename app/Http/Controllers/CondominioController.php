<?php

namespace App\Http\Controllers;

use App\Models\Condominio;
use App\Models\User;
use Illuminate\Http\Request;

class CondominioController extends Controller
{
    // Lista todos os condomínios
    public function index()
    {
        $user = auth()->user();

        // Verifica o papel do utilizador autenticado
        if ($user->role === 'admin') {
            // Se o utilizador for admin, mostra todos os condomínios
            $condominios = Condominio::all();
        } else {
            // Se o utilizador não for admin, mostra apenas o condomínio associado a ele
            $condominios = Condominio::where('id', $user->condominio_id)->get();
        }

        return view('condominios.index', compact('condominios'));
    }

    // Mostra um único condomínio
    public function show($id)
    {
        $condominio = Condominio::with('manager')->findOrFail($id);
        return view('condominios.show', compact('condominio'));
    }

    // Apaga um condomínio
    public function destroy($id)
    {
        if (auth()->check() && auth()->user()->role !== 'admin') {
            return redirect()->route('unauthorized'); // Redireciona para página de não autorizado
        }
        $condominio = Condominio::findOrFail($id);

        $hasUser = $condominio->users()->exists(); // Verifica se há utilizadores associados
        $hasReclamacao = $condominio->reclamacoes()->exists(); // Verifica se há reclamações associadas

        if ($hasUser || $hasReclamacao) {
            return redirect()->route('condominios.show', $id)
                ->with('error', __('Este condomínio não pode ser apagado pois tem um usuário ou reclamação associada.'));
        }

        $condominio->delete();
        return redirect()->route('condominios.index')->with('success', __('Condomínio apagado com sucesso.'));
    }

    // Cria um novo condomínio (formulário de criação)
    public function create()
    {
        if (auth()->check() && auth()->user()->role !== 'admin') {
            return redirect()->route('unauthorized'); 
        }

        $users = User::all();
        return view('condominios.create', compact('users'));
    }

    // Edita um condomínio
    public function edit($id)
    {
        $condominio = Condominio::findOrFail($id);

        // Verifica se o utilizador autenticado é o gestor do condomínio
        if (auth()->check() && (auth()->user()->role !== 'admin' && auth()->user()->id !== $condominio->manager_id)) {
            return redirect()->route('unauthorized'); 
        }

        $users = User::all(); // Obtém todos os utilizadores sem agrupar
        return view('condominios.edit', compact('condominio', 'users'));
    }

    // Guarda um novo condomínio
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'endereco' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'codigo_postal' => 'required|string|max:20',
        ]);

        // Obtém o utilizador autenticado (admin)
        $admin = auth()->user();

        // Cria o novo condomínio
        $condominio = Condominio::create([
            'nome' => $request->nome,
            'endereco' => $request->endereco,
            'cidade' => $request->cidade,
            'codigo_postal' => $request->codigo_postal,
            'manager_id' => $admin->id,  // Define o admin como gestor
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Atualiza o campo c_manager para o admin 
        $admin->update([
            'c_manager' => $condominio->id, // Define o c_manager do admin para o id do novo condomínio
        ]);

        return redirect()->route('condominios.show', $condominio->id)->with('success', __('Condomínio criado com sucesso!'));
    }

    // Atualiza os dados de um condomínio
    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'endereco' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'codigo_postal' => 'required|string|max:20',
            'manager_id' => 'required|exists:users,id',
        ]);

        $condominio = Condominio::findOrFail($id);
        $previousManager = User::findOrFail($condominio->manager_id);
        $newManager = User::findOrFail($request->manager_id);

        // Se o gestor do condomínio for alterado
        if ($condominio->manager_id != $request->manager_id) {
            // Limpa o campo c_manager do gestor anterior
            $previousManager->update(['c_manager' => null]);

            // Atualiza o campo c_manager do novo gestor
            $newManager->update(['c_manager' => $condominio->id]);

            // Atualiza o id do gestor do condomínio
            $condominio->update(['manager_id' => $request->manager_id]);
        }

        // Atualiza outros dados do condomínio
        $condominio->update([
            'nome' => $request->nome,
            'endereco' => $request->endereco,
            'cidade' => $request->cidade,
            'codigo_postal' => $request->codigo_postal,
        ]);

        return redirect()->route('condominios.show', $condominio->id)->with('success', __('Condomínio atualizado com sucesso!'));
    }

    // Lista os condomínios do utilizador autenticado
    public function meusCondominios()
    {
        $user = auth()->user();

        // Verifica se o utilizador é admin ou gestor de pelo menos um condomínio
        if ($user->role !== 'admin' && !Condominio::where('manager_id', $user->id)->exists()) {
            return redirect()->route('unauthorized'); // Redireciona se não for autorizado
        }

        // Obtém os condomínios onde o utilizador é o gestor
        $condominios = Condominio::where('manager_id', $user->id)->get();

        return view('condominios.user.index', compact('condominios'));
    }
}
