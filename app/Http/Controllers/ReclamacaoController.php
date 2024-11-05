<?php

namespace App\Http\Controllers;

use App\Models\Reclamacao;
use App\Models\TipoReclamacao;
use App\Models\Condominio;
use App\Models\Estado;
use Illuminate\Http\Request;
use App\Mail\NotificacaoEmail;
use Illuminate\Support\Facades\Mail;

class ReclamacaoController extends Controller
{
    public function index()
    {
        $reclamacoes = Reclamacao::with('tipoReclamacao', 'condominio', 'condomino', 'estado')->get();
        return view('reclamacoes.index', compact('reclamacoes'));
    }

    public function create()
    {
        $tiposReclamacao = TipoReclamacao::all();
        $condominios = Condominio::all(); // Adiciona a lista de condomínios
        return view('reclamacoes.create', compact('tiposReclamacao', 'condominios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'condomino_id' => 'required|integer',
            'condominio_id' => 'required|integer',
            'estado_id' => 'required|integer',
            'tipo_reclamacao_id' => 'required|integer',
            'descricao' => 'required|string',
            'email' => 'required|email',
        ]);

        Reclamacao::create([
            'condomino_id' => $request->condomino_id,
            'estado_id' => $request->estado_id,
            'condominio_id' => $request->condominio_id,
            'tipo_reclamacao_id' => $request->tipo_reclamacao_id,
            'descricao' => $request->descricao,
            'email' => $request->email,
        ]);

        // Dados para enviar no email
        $dados = [
            'nome' => $request->nome, // Supondo que você tenha o nome do condômino
            'descricao' => $request->descricao,
        ];

        // Enviar o email de notificação
        Mail::to($request->email)->send(new NotificacaoEmail($dados));


        return redirect()->route('reclamacoes.index')->with('success', 'Reclamação criada com sucesso!');
    }

    public function edit($id)
    {
        $reclamacao = Reclamacao::findOrFail($id);
        $condominios = Condominio::all(); // Obter todos os condomínios
        $tiposReclamacao = TipoReclamacao::all(); // Obter todos os tipos de reclamação
        $estadoReclamacao = Estado::all(); // Busca todos os status

        return view('reclamacoes.edit', compact('reclamacao', 'condominios', 'tiposReclamacao', 'estadoReclamacao'));
    }

    public function update(Request $request, $id)
    {
        // Validação dos dados recebidos
        $request->validate([
            'condomino_id' => 'required|integer',
            'condominio_id' => 'required|integer',
            'tipo_reclamacao_id' => 'required|integer',
            'descricao' => 'required|string',
            'estado_id' => 'required|integer',
        ]);

        // Buscando a reclamação pelo ID e garantindo a integridade dos dados
        $reclamacao = Reclamacao::findOrFail($id);

        // Atualizando os dados da reclamação
        $reclamacao->update([
            'condomino_id' => $request->condomino_id,
            'condominio_id' => $request->condominio_id,
            'tipo_reclamacao_id' => $request->tipo_reclamacao_id,
            'descricao' => $request->descricao,
            'estado_id' => $request->estado_id,
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


}
