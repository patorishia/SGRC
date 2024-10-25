<?php
namespace App\Http\Controllers;

use App\Models\Condomino;
use App\Models\Condominio;
use Illuminate\Http\Request;

class CondominoController extends Controller
{
    public function index()
    {
        // Obtém todos os condominos da tabela 'condomino'
        $condominos = Condomino::all(); 
        return view('gerente.index', compact('condominos')); // Retorna a view de condominos
    }

    public function show($id)
    {
        $condomino = Condomino::findOrFail($id); // Busca o condomino pelo ID
        return view('gerente.show', compact('condomino')); // Retorna a view com os detalhes
    }

    public function create()
    {
        $condominios = Condominio::all(); // Para obter a lista de condomínios
        return view('gerente.create', compact('condominios'));
    }

    public function edit($id)
    {
        $condomino = Condomino::findOrFail($id);
        $condominios = Condominio::all(); // Obtenha todos os condomínios para o dropdown
        return view('gerente.update', compact('condomino', 'condominios'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email',
            'telefone' => 'required|string|max:15',
            'condominio_id' => 'required|exists:condominios,id', // Certifique-se de que a relação é válida
        ]);
    
        $condomino = Condomino::findOrFail($id);
        $condomino->update($request->all());
    
        return redirect()->route('condominos.show', $id)->with('success', 'Condomino atualizado com sucesso.');
    }
    
    public function store(Request $request)
{
    $request->validate([
        'nome' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:condomino',
        'telefone' => 'required|string|max:255',
        'condominio_id' => 'required|exists:condominios,id', // Aqui o nome da tabela está correto
    ]);

    // Adiciona o novo condomino
    $condomino = new Condomino();
    $condomino->nome = $request->nome;
    $condomino->email = $request->email;
    $condomino->telefone = $request->telefone;
    $condomino->condominio_id = $request->condominio_id;
    $condomino->save();

    return redirect()->route('gerente.index')->with('success', 'Condomino criado com sucesso.');
}

public function destroy($id)
    {
        // Encontre o condomino pelo ID e delete
        $condomino = Condomino::findOrFail($id);
        $condomino->delete();

        // Redirecionar de volta para o índice com uma mensagem de sucesso
        return redirect()->route('condominos.index')->with('success', 'Condomino apagado com sucesso.');
    }
}

