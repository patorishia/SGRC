<?php

namespace App\Http\Controllers;

use App\Models\Reclamacao;
use App\Models\TipoReclamacao;
use App\Models\Condominio;
use App\Models\Estado;
use Illuminate\Http\Request;
use App\Mail\NotificacaoEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ReclamacaoController extends Controller
{
    public function index()
    {
        // Carrega todas as reclamações com as relações associadas
        $reclamacoes = Reclamacao::with('tipoReclamacao', 'condominio', 'condomino', 'estado')->get();
        return view('reclamacoes.index', compact('reclamacoes'));
    }

    public function create()
    {
        // Carrega todos os tipos de reclamação e condomínios
        $tiposReclamacao = TipoReclamacao::all();
        $condominios = Condominio::all();
        return view('reclamacoes.create', compact('tiposReclamacao', 'condominios'));
    }

    public function store(Request $request)
    {
        Log::info('Dados recebidos para criar reclamação:', $request->all());

        $request->validate([
            'condomino_id' => 'required|numeric|digits:8|exists:condomino,nif',
            'condominio_id' => 'required|integer',
            'tipo_reclamacao_id' => 'required|integer',
            'descricao' => 'required|string',
            'email' => 'required|email',
        ]);

        // Define o estado como 'pendente' ao criar uma nova reclamação
        $estadoId = 1; // Considerando que '1' representa o estado 'pendente'

        // Criar a reclamação
        $reclamacao = Reclamacao::create([
            'condomino_id' => $request->condomino_id,
            'estado_id' => $estadoId,
            'condominio_id' => $request->condominio_id,
            'tipo_reclamacao_id' => $request->tipo_reclamacao_id,
            'descricao' => $request->descricao,
            'email' => $request->email,
        ]);

        // Dados para o e-mail de notificação
        $dados = [
            'nome' => $request->nome,
            'descricao' => $request->descricao,
        ];

        // Envia o e-mail de notificação para o e-mail fornecido
        Mail::to($request->email)->send(new NotificacaoEmail($dados));

        // Redireciona para a página de reclamações com uma mensagem de sucesso
        return redirect()->route('reclamacoes.index')->with('success', 'Reclamação criada com sucesso!');
    }

    public function edit($id)
    {
        // Obtém a reclamação e as opções para dropdowns
        $reclamacao = Reclamacao::findOrFail($id);
        $condominios = Condominio::all();
        $tiposReclamacao = TipoReclamacao::all();
        $estadoReclamacao = Estado::all();

        return view('reclamacoes.edit', compact('reclamacao', 'condominios', 'tiposReclamacao', 'estadoReclamacao'));
    }

    public function update(Request $request, $id)
    {
        // Valida os dados atualizados da reclamação
        $request->validate([
            'condomino_id' => 'required|integer',
            'condominio_id' => 'required|integer',
            'tipo_reclamacao_id' => 'required|integer',
            'descricao' => 'required|string',
            'estado_id' => 'required|integer',
        ]);

        // Busca a reclamação pelo ID
        $reclamacao = Reclamacao::findOrFail($id);

        // Atualiza os dados da reclamação
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
        // Encontra e exclui a reclamação pelo ID
        $reclamacao = Reclamacao::findOrFail($id);
        $reclamacao->delete();

        return redirect()->route('reclamacoes.index')->with('success', 'Reclamação apagada com sucesso!');
    }
}

