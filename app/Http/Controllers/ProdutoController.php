<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProdutoController extends Controller
{
    // Método para exibir todos os produtos
    public function index()
    {
        if (auth()->check() && auth()->user()->role !== 'admin') {
            return redirect()->route('unauthorized'); 
        }
        return view('produtos.index');
    }

    // Método para exibir o formulário de criação de um novo produto
    public function create()
    {
        if (auth()->check() && auth()->user()->role !== 'admin') {
            return redirect()->route('unauthorized'); 
        }
        return view('produtos.create');
    }

    // Método para exibir o formulário de edição com os dados do produto
    public function edit($id)
    {
        if (auth()->check() && auth()->user()->role !== 'admin') {
            return redirect()->route('unauthorized'); 
        }
        // Recupera os dados do produto através da API usando o ID
        $token = $this->getToken();
        $response = Http::withHeaders(['Authorization' => $token])
                        ->get("https://devipvc.gesfaturacao.pt/gesfaturacao/server/webservices/api/mobile/v1.0.2/products/{$id}");

        if (!$response->ok()) {
            return redirect()->back()->with('error', 'Produto não encontrado!');
        }

        // Obtém o array de produtos da resposta da API
        $products = $response->json()['data'];

        // Encontra o produto com o ID fornecido
        $product = collect($products)->firstWhere('id', $id);

        if (!$product) {
            return redirect()->back()->with('error', 'Produto não encontrado!');
        }

        return view('produtos.edit', compact('product'));
    }

    // Método para atualizar um produto existente
    public function update(Request $request, $id)
    {
        // Valida os dados recebidos
        $request->validate([
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
            
        ]);

        // Recupera o token para autorização
        $token = $this->getToken();

        // Prepara os dados para atualizar o produto
        $updatedData = [
            'description' => $request->description,
            'price' => $request->price,
        ];

        // Envia o pedido PUT para atualizar o produto
        try {
            $response = Http::withHeaders(['Authorization' => $token])
                            ->put("https://devipvc.gesfaturacao.pt/gesfaturacao/server/webservices/api/mobile/v1.0.2/products/{$id}", $updatedData);
        
            // Regista a resposta para depuração
            \Log::debug('Resposta da API: ', $response->json());
        
            if ($response->ok()) {
                return redirect()->route('produtos.index')->with('success', __('Produto atualizado com sucesso!'));
            } else {
                // Regista a resposta de erro para mais detalhes
                \Log::error('Falha ao atualizar o produto:', $response->json());
                return back()->with('error', __('Erro ao atualizar produto!'))->withInput();
            }
        } catch (\Exception $e) {
            \Log::error('Exceção durante a atualização do produto:', ['message' => $e->getMessage()]);
            return back()->with('error', __('Erro ao atualizar produto: ') . $e->getMessage())->withInput();
        }
    }

    // Método privado para obter o token de autenticação
    private function getToken()
    {
        $response = Http::post('https://devipvc.gesfaturacao.pt/gesfaturacao/server/webservices/api/mobile/v1.0.2/authentication', [
            'username' => 'ipvc',
            'password' => 'ipvc',
        ]);
        return $response->json()['_token'];
    }

    // Método para atualizar as informações de um produto
    public function updateProduct(Request $request, $id)
    {
        // Prepara os dados a serem enviados para a API
        $data = [
            'id' => $id,  // ID do produto a ser atualizado
            'code' => $request->input('code'),
            'name' => $request->input('name'),
            'category' => $request->input('category'),
            'type' => $request->input('type'),
            'stock' => $request->input('stock'),
            'minStock' => $request->input('minStock'),
            'stockAlert' => $request->input('stockAlert'),
            'unity' => $request->input('unity'),
            'pvp' => $request->input('pvp'),
            'tax' => $request->input('tax'),
            'price' => $request->input('price'),
            'serialNumber' => $request->input('serialNumber'),
            'retention' => $request->input('retention'),
            'retentionPercentage' => $request->input('retentionPercentage'),
            'exemptionReason' => $request->input('exemptionReason'),
            'observations' => $request->input('observations'),
            'label' => $request->input('label'),
            'image' => $request->input('image'),
            'initialPrice' => $request->input('initialPrice'),
            'pricesLines' => $request->input('pricesLines'),
            'supplierLines' => $request->input('supplierLines'),
            'barcodes' => $request->input('barcodes'),
        ];

        // Faz o pedido PUT para a API externa
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('API_TOKEN'),  
            'Cookie' => 'PHPSESSID=' . session('PHPSESSID'),  
        ])->put('https://devipvc.gesfaturacao.pt/gesfaturacao/server/webservices/api/mobile/v1.0.2/products', $data);

        // Verifica se o pedido foi bem-sucedido
        if ($response->successful()) {
            return response()->json(['message' => 'Produto atualizado com sucesso!']);
        } else {
            return response()->json(['error' => 'Falha ao atualizar produto'], 500);
        }
    }
}
