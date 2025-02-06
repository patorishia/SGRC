<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ClienteController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->role !== 'admin') {
            return redirect()->route('unauthorized'); 
        }
        // Obter todos os NIFs da tabela de utilizadores
        $nifList = \DB::table('users')->pluck('nif')->toArray();
    
        return view('clientes.index', compact('nifList'));
    }

    public function create()
    {
        if (auth()->check() && auth()->user()->role !== 'admin') {
            return redirect()->route('unauthorized'); 
        }
        return view('clientes.create');
    }

    public function getUsers() {
        // Obter utilizadores da tabela 'users' na base de dados
        $users = DB::table('users')->select('telefone', 'name', 'nif')->get();
        return response()->json($users); // Assegura que retorna JSON
    }

    public function edit($id)
    {
        if (auth()->check() && auth()->user()->role !== 'admin') {
            return redirect()->route('unauthorized'); 
        }
        // Obter o token de autenticação
        $token = $this->getToken();

        // Fazer a requisição para a API externa
        $response = Http::withHeaders(['Authorization' => $token])
                        ->get("https://devipvc.gesfaturacao.pt/gesfaturacao/server/webservices/api/mobile/v1.0.2/clients");

        $clients = $response->json()['data'];

        // Procurar o cliente com o id correspondente
        $client = collect($clients)->firstWhere('id', $id);

        // Se o cliente não for encontrado, retornar erro
        if (!$client) {
            return redirect()->back()->with('error', __('Cliente não encontrado!'));
        }

        return view('clientes.edit', compact('client'));
    }

    // Método para atualizar os detalhes do cliente
    public function update(Request $request, $id)
    {
        // Validar os dados recebidos
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'postalCode' => 'required|string|max:10',
            // Adicionar outras validações conforme necessário
        ]);
    
        // Obter o token de autenticação
        $token = $this->getToken();
    
        // Preparar os dados para atualizar o cliente
        $updatedData = [
            'name' => $request->name,
            'address' => $request->address,
            'postalCode' => $request->postalCode,
            // Adicionar outros campos a atualizar conforme necessário
        ];
    
        // Enviar a requisição PUT para atualizar o cliente
        try {
            $response = Http::withHeaders(['Authorization' => $token])
                            ->put("https://devipvc.gesfaturacao.pt/gesfaturacao/server/webservices/api/mobile/v1.0.2/clients/{$id}", $updatedData);
    
            // Se a resposta for positiva, redirecionar com mensagem de sucesso
            if ($response->ok()) {
                return redirect()->route('clientes.index')->with('success', __('Cliente atualizado com sucesso!'));
            } else {
                return back()->with('error', __('Erro ao atualizar cliente!'))->withInput();
            }
        } catch (\Exception $e) {
            // Em caso de erro, retornar com mensagem de erro
            return back()->with('error', __('Erro ao atualizar cliente: ') . $e->getMessage())->withInput();
        }
    }

    // Método privado para obter o token de autenticação
    private function getToken()
    {
        // Enviar requisição POST para obter o token
        $response = Http::post('https://devipvc.gesfaturacao.pt/gesfaturacao/server/webservices/api/mobile/v1.0.2/authentication', [
            'username' => 'ipvc',
            'password' => 'ipvc',
        ]);
        return $response->json()['_token'];
    }
}
