<?php

namespace App\Http\Controllers;

use App\Models\Condominio; // Certifique-se de que você importou o modelo
use Illuminate\Http\Request;

class CondominioController extends Controller
{
    // Exibir a lista de condomínios
    public function index()
    {
        $condominios = Condominio::all();
        return view('condominios.index', compact('condominios'));
    }


    // Exibir o formulário para criar um novo condomínio
    public function create()
    {
        return view('condominios.create'); // Crie esta view para o formulário
    }

    // Armazenar um novo condomínio
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
        ]);

        return redirect()->route('condominios.index')->with('success', 'Condomínio criado com sucesso!');
    }

      // Exibir um condomínio específico
      public function show($id)
      {
          $condominio = Condominio::findOrFail($id);
          return view('condominios.show', compact('condominio'));
      }

    // Exibir o formulário para editar um condomínio
    public function edit($id)
    {
        $condominio = Condominio::findOrFail($id);
        return view('condominios.edit', compact('condominio'));
    }

    // Atualizar um condomínio específico
    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'endereco' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'codigo_postal' => 'required|string|max:20',
        ]);

        $condominio = Condominio::findOrFail($id);
        $condominio->update([
            'nome' => $request->nome,
            'endereco' => $request->endereco,
            'cidade' => $request->cidade,
            'codigo_postal' => $request->codigo_postal,
        ]);

        return redirect()->route('condominios.index')->with('success', 'Condomínio atualizado com sucesso!');
    }

    // Excluir um condomínio específico
    public function destroy($id)
    {
        $condominio = Condominio::findOrFail($id);
        $condominio->delete();

        return redirect()->route('condominios.index')->with('success', 'Condomínio excluído com sucesso!');
    }
}