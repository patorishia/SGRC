<?php

namespace App\Http\Controllers;

use App\Models\Reclamacao;
use Illuminate\Http\Request;

class ReclamacaoController extends Controller
{
    public function index()
    {
        $reclamacoes = Reclamacao::all(); // Ou filtre conforme necessário
        return view('reclamacoes.index', compact('reclamacoes'));
    }

    public function create()
    {
        return view('reclamacoes.create');
        $tipos = TipoReclamacao::all(); // Obter todos os tipos de reclamação
        return view('reclamacoes.create', compact('tipos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'condomino_id' => 'required|integer',
            'condominio_id' => 'required|integer',
            'tipo_reclamacao' => 'required|string|max:255',
            'descricao' => 'required|string',
            // Adicione outras validações conforme necessário
        ]);

        Reclamacao::create([
            'condomino_id' => $request->condomino_id,
            'condominio_id' => $request->condominio_id,
            'tipo_reclamacao' => $request->tipo_reclamacao,
            'descricao' => $request->descricao,
            'estado' => 'pendente', // Por exemplo, estado inicial
            'data_criacao' => now(),
            // 'data_resolucao' => null, // Deixe em branco inicialmente
        ]);

        return redirect()->route('reclamacoes.index')->with('success', 'Reclamação criada com sucesso!');
    }

    public function edit(Reclamacao $reclamacao)
    {
        return view('reclamacoes.edit', compact('reclamacao'));
    }

    public function update(Request $request, Reclamacao $reclamacao)
    {
        $request->validate([
            'tipo_reclamacao' => 'required|string|max:255',
            'descricao' => 'required|string',
        ]);

        $reclamacao->update($request->only(['tipo_reclamacao', 'descricao']));

        return redirect()->route('reclamacoes.index')->with('success', 'Reclamação atualizada com sucesso!');
    }

    public function destroy(Reclamacao $reclamacao)
    {
        $reclamacao->delete();
        return redirect()->route('reclamacoes.index')->with('success', 'Reclamação excluída com sucesso!');
    }
}
