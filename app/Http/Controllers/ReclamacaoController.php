<?php

namespace App\Http\Controllers;

use App\Models\Reclamacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Condominio;
use App\Models\Condomino; // Também importando Condomino se necessário
use App\Models\TiposReclamacao; // Importando TipoReclamacao


class ReclamacaoController extends Controller
{
    public function index()
    {
        $reclamacoes = Reclamacao::all(); // Ou filtre conforme necessário
        return view('reclamacoes.index', compact('reclamacoes'));
    }

    public function create()
{
    $condominios = Condominio::all(); // Obter todos os condomínios
    $condominos = Condomino::all(); // Obter todos os condominos
    $tiposReclamacao = TiposReclamacao::all(); // Obter todos os tipos de reclamação

    return view('reclamacoes.create', compact('condominios', 'condominos', 'tiposReclamacao'));
}

public function store(Request $request)
{
    $validatedData = $request->validate([
        'condominio_id' => 'required|exists:condominios,id',
        'condomino_id' => 'required|exists:condomino,id',
        'tipo_reclamacao' => 'required|exists:tipos_reclamacao,id',
        'descricao' => 'required|string|max:255',
        'estado' => 'required|string|max:255',
    ]);

    $reclamacao = new Reclamacao();
    $reclamacao->condominio_id = $validatedData['condominio_id'];
    $reclamacao->condomino_id = $validatedData['condomino_id'];
    $reclamacao->tipo_reclamacao = $validatedData['tipo_reclamacao'];
    $reclamacao->descricao = $validatedData['descricao'];
    $reclamacao->estado = $validatedData['estado'];
    $reclamacao->data_criacao = now(); // Data de criação
    // Opcional: Se você quiser também definir uma data de resolução, pode adicionar isso aqui
    $reclamacao->save();

    return redirect()->route('reclamacoes.index')->with('success', 'Reclamação criada com sucesso!');
}


public function edit($id)
{
    $reclamacao = Reclamacao::findOrFail($id);
    $condominos = Condomino::all(); // Obter todos os condominos
    $condominios = Condominio::all(); // Obter todos os condomínios
    $tipos_reclamacao = TiposReclamacao::all(); // Obter todos os tipos de reclamação

    return view('reclamacoes.edit', compact('reclamacao', 'condominos', 'condominios', 'tipos_reclamacao'));
}

public function update(Request $request, $id)
{
    $reclamacao = Reclamacao::findOrFail($id);

    $reclamacao->update([
        'condomino_id' => $request->condomino_id,
        'condominio_id' => $request->condominio_id,
        'tipo_reclamacao' => $request->tipo_reclamacao,
        'descricao' => $request->descricao,
        'estado' => $request->estado,
        'data_criacao' => now(), // ou deixe isso fora se você não quer atualizar
        // 'data_resolucao' pode ser atualizado conforme necessário
    ]);

    return redirect()->route('reclamacoes.index')->with('success', 'Reclamação atualizada com sucesso!');
}


    public function destroy($id)
{
    // Encontre a reclamação pelo ID
    $reclamacao = Reclamacao::findOrFail($id);
    
    // Exclua a reclamação
    $reclamacao->delete();

    // Redirecione de volta para o índice com uma mensagem de sucesso
    return redirect()->route('reclamacoes.index')->with('success', 'Reclamação apagada com sucesso!');
}


    public function show($id)
{
    $reclamacao = Reclamacao::with(['condomino', 'condominio', 'tipoReclamacao'])->findOrFail($id);

    return view('reclamacoes.show', compact('reclamacao'));
}
}
