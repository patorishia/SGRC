<?php

namespace App\Http\Controllers;

use App\Models\TiposReclamacao;
use Illuminate\Http\Request;

class TiposReclamacaoController extends Controller
{
    public function index()
    {
        $tiposReclamacao = TiposReclamacao::all();
        return view('tipos_reclamacao.index', compact('tiposReclamacao'), ['pageTitle' => 'Tipos de Reclamação']);
    }

    public function create()
    {
        return view('tipos_reclamacao.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required',
            'descricao' => 'nullable|string',
        ]);

        TiposReclamacao::create($request->all());
        return redirect()->route('tipos_reclamacao.index')->with('success', 'Tipo de reclamação criado com sucesso.');
    }

    public function show(TiposReclamacao $tiposReclamacao)
    {
        return view('tipos_reclamacao.show', compact('tiposReclamacao'));
    }

    public function edit($id)
{
    $tipoReclamacao = TiposReclamacao::findOrFail($id);
    return view('tipos_reclamacao.edit', compact('tipoReclamacao'));
}

    public function update(Request $request, TiposReclamacao $tiposReclamacao)
    {
        $request->validate([
            'tipo' => 'required',
            'descricao' => 'nullable|string',
        ]);

        $tiposReclamacao->update($request->all());
        return redirect()->route('tipos_reclamacao.index')->with('success', 'Tipo de reclamação atualizado com sucesso.');
    }

    public function destroy(TiposReclamacao $tiposReclamacao)
    {
        // Verifica se o tipo de reclamação está sendo utilizado em algum outro lugar
        if ($tiposReclamacao->reclamacoes()->count() > 0) {
            // Se o tipo estiver sendo usado, retorna uma mensagem de erro
            return back()->with('error', 'Este tipo de reclamação está sendo utilizado em outra(s) reclamação(ões) e não pode ser apagado.');
        }
    
        // Caso contrário, apaga o tipo de reclamação
        $tiposReclamacao->delete();
        return redirect()->route('tipos_reclamacao.index')->with('success', 'Tipo de Reclamação apagado com sucesso!');
    }
    

    


}
