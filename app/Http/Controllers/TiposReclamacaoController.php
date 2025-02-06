<?php

namespace App\Http\Controllers;

use App\Models\TiposReclamacao;
use Illuminate\Http\Request;

class TiposReclamacaoController extends Controller
{
    /**
     * Exibe todos os tipos de reclamação.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Verifica se o utilizador está autenticado e não é administrador
        if (auth()->check() && auth()->user()->role !== 'admin') {
            return redirect()->route('unauthorized'); 
        }

        // Obtém todos os tipos de reclamação
        $tiposReclamacao = TiposReclamacao::all();

        // Retorna a vista com os tipos de reclamação
        return view('tipos_reclamacao.index', compact('tiposReclamacao'), ['pageTitle' => __('Tipos de Reclamação')]);
    }

    /**
     * Exibe o formulário para criar um novo tipo de reclamação.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        
        if (auth()->check() && auth()->user()->role !== 'admin') {
            return redirect()->route('unauthorized'); // Redireciona para a página de acesso não autorizado
        }

        // Retorna a vista com o formulário de criação de tipo de reclamação
        return view('tipos_reclamacao.create');
    }

    /**
     * Armazena um novo tipo de reclamação.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Valida os dados do formulário
        $request->validate([
            'tipo' => 'required', 
            'descricao' => 'nullable|string', // Descrição é opcional
        ]);

        // Cria o novo tipo de reclamação com os dados do formulário
        TiposReclamacao::create($request->all());

        // Redireciona para a lista de tipos de reclamação com uma mensagem de sucesso
        return redirect()->route('tipos_reclamacao.index')->with('success', __('Tipo de reclamação criado com sucesso.'));
    }

    /**
     * Exibe os detalhes de um tipo de reclamação específico.
     *
     * @param \App\Models\TiposReclamacao $tiposReclamacao
     * @return \Illuminate\View\View
     */
    public function show(TiposReclamacao $tiposReclamacao)
    {
        
        if (auth()->check() && auth()->user()->role !== 'admin') {
            return redirect()->route('unauthorized'); 
        }

        // Retorna a vista com os detalhes do tipo de reclamação
        return view('tipos_reclamacao.show', compact('tiposReclamacao'));
    }

    /**
     * Exibe o formulário para editar um tipo de reclamação existente.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
       
        if (auth()->check() && auth()->user()->role !== 'admin') {
            return redirect()->route('unauthorized'); 
        }

        // Encontra o tipo de reclamação pelo ID
        $tipoReclamacao = TiposReclamacao::findOrFail($id);

        // Retorna a vista com o formulário de edição do tipo de reclamação
        return view('tipos_reclamacao.edit', compact('tipoReclamacao'));
    }

    /**
     * Atualiza um tipo de reclamação existente.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TiposReclamacao $tiposReclamacao
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, TiposReclamacao $tiposReclamacao)
    {
        // Valida os dados do formulário
        $request->validate([
            'tipo' => 'required', 
            'descricao' => 'nullable|string', 
        ]);

        // Atualiza o tipo de reclamação com os novos dados
        $tiposReclamacao->update($request->all());

        // Redireciona para a lista de tipos de reclamação com uma mensagem de sucesso
        return redirect()->route('tipos_reclamacao.index')->with('success', __('Tipo de reclamação atualizado com sucesso.'));
    }

    /**
     * Apaga um tipo de reclamação existente.
     *
     * @param \App\Models\TiposReclamacao $tiposReclamacao
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(TiposReclamacao $tiposReclamacao)
    {
        // Verifica se o tipo de reclamação está a ser utilizado em outras reclamações
        if ($tiposReclamacao->reclamacoes()->count() > 0) {
            // Se o tipo estiver a ser usado, retorna uma mensagem de erro
            return back()->with('error', __('Este tipo de reclamação está a ser utilizado em outra(s) reclamação(ões) e não pode ser apagado.'));
        }
    
        // Caso contrário, apaga o tipo de reclamação
        $tiposReclamacao->delete();

        // Redireciona para a lista de tipos de reclamação com uma mensagem de sucesso
        return redirect()->route('tipos_reclamacao.index')->with('success', __('Tipo de Reclamação apagado com sucesso!'));
    }
}
