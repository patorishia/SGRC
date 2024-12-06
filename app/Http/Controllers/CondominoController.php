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
        return view('gerente.index', compact('condominos'), ['pageTitle' => __('Condóminos')]); // Retorna a view de condominos~
        
    }

    public function show($nif)
    {
        $condomino = Condomino::findOrFail($nif); // Busca o condomino pelo nif
        return view('gerente.show', compact('condomino')); // Retorna a view com os detalhes
    }

    public function create()
    {
        $condominios = Condominio::all(); // Para obter a lista de condomínios
        return view('gerente.create', compact('condominios'));
    }

    public function edit($nif)
    {
        $condomino = Condomino::findOrFail($nif);
        $condominios = Condominio::all(); // Obtenha todos os condomínios para o dropdown
        return view('gerente.update', compact('condomino', 'condominios'));
    }

    public function update(Request $request, $nif)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email',
            'telefone' => 'required|string|max:15',
            'condominio_id' => 'required|exists:condominio,id', // Certifique-se de que a relação é válida
        ]);
    
        $condomino = Condomino::findOrFail($nif);
        $condomino->update($request->all());
    
        return redirect()->route('condominos.show', $nif)->with('success', 'Condomino atualizado com sucesso.');
    }
    
    public function store(Request $request)
{
    $request->validate([
        'nome' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:condomino',
        'telefone' => 'required|string|max:255',
        'condominio_id' => 'required|exists:condominio,id', // Aqui o nome da tabela está correto
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

public function destroy($nif)
{
    $condomino = Condomino::findOrFail($nif);

    // Verificar se o condomino tem reclamações associadas
    $hasReclamacao = $condomino->reclamacoes()->exists();

    if ($hasReclamacao) {
        // Se o condomino tiver reclamações, retornar para a página de show com a mensagem de erro
        return redirect()->route('condominos.show', $nif)
                         ->with('error', 'Este condomino não pode ser apagado pois tem uma reclamação associada.');
    }

    // Caso contrário, apague o condomino
    $condomino->delete();

    // Redirecionar para a lista de condominos com a mensagem de sucesso
    return redirect()->route('gerente.index')
                     ->with('success', 'Condomino apagado com sucesso.');
}



}

