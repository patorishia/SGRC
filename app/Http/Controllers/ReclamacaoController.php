<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reclamacao;

class ReclamacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $reclamacoes = Reclamacao::all();
        return view('reclamacao.index', compact('reclamacoes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('reclamacao.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'tipo_reclamacao' => 'required',
            'descricao' => 'required',
            'estado' => 'required',
            'condominio_id' => 'required|exists:condominios,id',
            'condomino_id' => 'required|exists:condomino,id',
        ]);

        Reclamacao::create($request->all());
        return redirect()->route('reclamacao.index')->with('success', 'Reclamação criada com sucesso!');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Reclamacao $reclamacao)
    {
        //
        return view('reclamacao.show', compact('reclamacao'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reclamacao $reclamacao)
    {
        //
        return view('reclamacao.edit', compact('reclamacao'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
