<?php

namespace App\Http\Controllers;

use App\Models\Condominio; // Certifique-se de que você importou o modelo
use Illuminate\Http\Request;

class CondominioController extends Controller
{
    public function index()
{
    $condominios = Condominio::all();

    // Remova a linha de depuração e passe os dados diretamente para a view
    return view('condominios.index', compact('condominios'),['pageTitle' => __('Condomínios')]);
}


public function show($id)
{
    $condominio = Condominio::findOrFail($id);
    return view('condominios.show', compact('condominio'));
}

public function destroy($id)
{
    $condominio = Condominio::findOrFail($id);

    // Verificar se o condomínio tem algum condomino ou reclamação associada
    $hasCondomino = $condominio->condominos()->exists();
    $hasReclamacao = $condominio->reclamacoes()->exists();

    if ($hasCondomino || $hasReclamacao) {
        // Se houver, não pode apagar e retorna com uma mensagem de erro
        return redirect()->route('condominios.show', $id)
                         ->with('error', 'Este condomínio não pode ser apagado pois tem um condômino ou reclamação associada.');
    }

    // Caso contrário, apague o condomínio
    $condominio->delete();

    // Redirecionar para o índice com uma mensagem de sucesso
    return redirect()->route('condominios.index')
                     ->with('success', 'Condomínio apagado com sucesso.');
}



    public function create()
    {
        return view('condominios.create'); // Crie esta view para o formulário
    }
    public function edit($id)
    {
        // Encontra o condomínio pelo ID
        $condominio = Condominio::findOrFail($id);

        // Retorna a view de edição com os dados do condomínio
        return view('condominios.edit', compact('condominio'));
    }

    // Método para atualizar o condomínio
    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'endereco' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'codigo_postal' => 'required|string|max:20',
        ]);

        // Encontra o condomínio pelo ID
        $condominio = Condominio::findOrFail($id);

        // Atualiza os dados do condomínio
        $condominio->update([
            'nome' => $request->nome,
            'endereco' => $request->endereco,
            'cidade' => $request->cidade,
            'codigo_postal' => $request->codigo_postal,
        ]);

        // Redireciona para a página de listagem com uma mensagem de sucesso
        return redirect()->route('condominios.index')->with('success', 'Condomínio atualizado com sucesso!');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'endereco' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'codigo_postal' => 'required|string|max:20',
        ]);

        Condominio::create([
            'nome' => $request->nome,
            'endereco' => $request->endereco,
            'cidade' => $request->cidade,
            'codigo_postal' => $request->codigo_postal,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('condominios.index')->with('success', 'Condomínio criado com sucesso!');
    }
}

