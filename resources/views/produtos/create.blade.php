@extends('layouts.app')

@section('title', 'Formulário de Criação de Produto')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Produto/Renda') }}</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Card principal com mais margem e espaçamento -->
    <div class="container mx-auto mt-12 flex justify-center">
        <div class="card shadow-lg w-full max-w-2xl mt-4 rounded-lg">
            <div class="card-header bg-blue-600 text-black text-center py-4">
                <h3 class="card-title font-bold text-xl ">{{ __('Adicionar Produto/Renda') }}</h3>
            </div>

            <div class="card-body">
                <form id="productForm">
                    @csrf

                   <!-- Campo Código do Produto -->
                   <div class="form-group mb-4">
                        <label for="code" class="control-label">{{ __('Código do Produto') }}:</label>
                        <input type="text" id="code" name="code" class="form-control" value="SGRC-" required oninput="restrictCodeInput(this)" pattern="SGRC-[0-9A-Za-z]+" />
                    </div>

                    <!-- Campo Nome -->
                    <div class="form-group mb-4">
                        <label for="name" class="control-label">{{ __('Nome') }}:</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>

                    <!-- Campo Unidade -->
                    <div class="form-group mb-4">
                        <label for="unity" class="control-label">{{ __('Unidade (ID)') }}:</label>
                        <input type="text" id="unity" name="unity" class="form-control" value="1" required>
                    </div>

                    <!-- Campo Tipo -->
                    <div class="form-group mb-4">
                        <label for="type" class="control-label">{{ __('Tipo (S, P, I)') }}:</label>
                        <input type="text" id="type" name="type" class="form-control" maxlength="1" value="S" required>
                    </div>

                    <!-- Campo Preço -->
                    <div class="form-group mb-4">
                        <label for="price" class="control-label">{{ __('Preço') }}:</label>
                        <input type="number" step="0.01" id="price" name="price" class="form-control" required>
                    </div>

                    <!-- Campo PVP -->
                    <div class="form-group mb-4">
                        <label for="pvp" class="control-label">{{ __('PVP') }}:</label>
                        <input type="number" step="0.01" id="pvp" name="pvp" class="form-control" required readonly>
                    </div>

                    <!-- Campo ID do Imposto -->
                    <div class="form-group mb-4">
                        <label for="tax" class="control-label">{{ __('ID do Imposto') }}:</label>
                        <input type="text" id="tax" name="tax" class="form-control" value="IVA" readonly>
                        <input type="hidden" id="taxValue" name="tax" value="1"> 
                    </div>

                    <!-- Botão de Enviar -->
                    <div class="text-center">
                        <button type="button" class="btn btn-success" onclick="createProduct()">
                            <i class="fas fa-plus-circle"></i> {{ __('Criar Produto/Renda') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<!-- Modal de Sucesso -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">{{ __('Produto Criado com Sucesso') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ __('O produto foi criado com sucesso!') }}
            </div>
            <div class="modal-footer">
                <a href="{{ route('produtos.index') }}" class="btn btn-primary">{{ __('Voltar à Lista de Produtos') }}</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Erro (Produto Já Existe) -->
<div class="modal fade" id="dangerModal" tabindex="-1" role="dialog" aria-labelledby="dangerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger" id="dangerModalLabel">{{ __('Erro ao Criar Produto') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-danger">
                {{ __('Já existe um produto com esse código. Por favor, escolha um código diferente.') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Fechar') }}</button>
            </div>
        </div>
    </div>
</div>

<script>
    const API_URL = "https://devipvc.gesfaturacao.pt/gesfaturacao/server/webservices/api/mobile/v1.0.2";

    // Função para obter o token de autenticação
    async function getToken() {
        const response = await fetch(API_URL + "/authentication", {
            method: "POST",
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                username: "ipvc", 
                password: "ipvc"  
            })
        });
        const data = await response.json();
        return data._token; // Retorna o token
    }

    // Função para atualizar o campo PVP
    function updatePVP() {
        const price = parseFloat(document.getElementById("price").value);
        if (!isNaN(price)) {
            const pvp = (price * 1.23).toFixed(2); // Calcula 123% do preço
            document.getElementById("pvp").value = pvp;
        }
    }

    async function createProduct() {
        // Obtem os dados do formulário
        const code = document.getElementById("code").value;
        const name = document.getElementById("name").value;
        const unity = document.getElementById("unity").value;
        const type = document.getElementById("type").value;
        const price = document.getElementById("price").value;
        const tax = document.getElementById("taxValue").value; // Obtem o valor oculto do imposto
        const pvp = document.getElementById("pvp").value;

        // Configura os dados para enviar
        const urldata = new URLSearchParams();
        urldata.append('code', code);
        urldata.append('name', name);
        urldata.append('unity', unity);
        urldata.append('type', type);
        urldata.append('price', price); // Preço PVP
        urldata.append('tax', tax); // ID do Imposto (enviado como 1)
        urldata.append('pvp', pvp); // Preço PVP

        try {
            const token = await getToken();  // Obtem o token

            // Envia a requisição com o token obtido
            const response = await fetch(API_URL + "/products", {
                method: "POST",
                headers: {
                    'Authorization': token,
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: urldata
            });

            if (!response.ok) {
                throw new Error(`Erro na requisição: ${response.status}`);
            }

            const data = await response.json();
            console.log("Produto criado:", data);

            // Exibe o modal de sucesso
            $('#successModal').modal('show');
        } catch (error) {
            console.error("Erro ao criar produto:", error);
            
            // Exibe o modal de erro (produto já existe)
            $('#dangerModal').modal('show');
        }
    }

    function restrictCodeInput(input) {
        // Garante que o código comece com 'SGRC-' e não permite a remoção dessa parte
        if (!input.value.startsWith("SGRC-")) {
            input.value = "SGRC-";
        }
    }

    // Adiciona o evento para atualizar o PVP sempre que o preço mudar
    document.getElementById("price").addEventListener("input", updatePVP);
</script>

<!-- Scripts do Bootstrap para o modal -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
