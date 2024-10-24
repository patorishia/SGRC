<?php

namespace App\Http\Controllers;

use App\Models\Reclamacao;
use App\Models\TipoReclamacao;
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
        $tiposReclamacao = TipoReclamacao::all();
        return view('reclamacoes.create', compact('tiposReclamacao'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'condomino_id' => 'required|integer',
            'condominio_id' => 'required|integer',
            'tipo_reclamacao_id' => 'required|integer', //Alterado
            'descricao' => 'required|string',
        ]);

        Reclamacao::create([
            'condomino_id' => $request->condomino_id,
            'condominio_id' => $request->condominio_id,
            'tipo_reclamacao_id' => $request->tipo_reclamacao_id, //Alterado
            'descricao' => $request->descricao,
            'estado' => 'pendente', 
            'created_at' => now(), //Alterado
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
            'tipo_reclamacao_id' => 'required|integer', // Alterado
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
