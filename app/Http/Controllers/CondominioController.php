<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CondominioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $condominios = Condominio::all();
        return view('condominio.index', compact('condominio'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('condominio.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'nome' => 'required|string|max:100',
            'endereco' => 'required|string|max:255',
            'cidade' => 'required|string|max:100',
            'codigo_postal' => 'required|string|max:20',
        ]);

        Condominio::create($request->all());

        return redirect()->route('condominio.index')->with('success', 'Condomínio criado com sucesso.');
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Condominio $condominio)
    {
        //
        return view('condominios.show', compact('condominio'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Condominio $condominio)
    {
        //
        return view('condominio.edit', compact('condominio'));
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
