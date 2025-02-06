@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Cliente') }}</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Card principal com mais margem e espaçamento -->
    <div class="container mx-auto mt-12 flex justify-center">
        <div class="card shadow-lg w-full max-w-2xl mt-4 rounded-lg">
            <div class="card-header bg-blue-600 text-black text-center py-4">
                <h3 class="card-title font-bold text-xl">{{ __('Criação de Cliente') }}</h3>
            </div>

            <div class="card-body">
                <form id="clientForm">
                    @csrf

                    <!-- Campo Nome -->
                    <div class="form-group mb-4">
                        <label for="name" class="control-label">{{ __('Nome') }}:</label>
                        <select id="name" name="name" class="form-control" required onchange="fillNIF()">
                            <option value="">Selecione um usuário</option>
                            <!-- As opções serão carregadas dinamicamente aqui -->
                        </select>
                    </div>

                    <!-- Campo NIF -->
                    <div class="form-group mb-4">
                        <label for="nif" class="control-label">{{ __('NIF') }}:</label>
                        <input type="text" id="nif" name="nif" class="form-control" readonly required>
                    </div>

                    <!-- Campo País -->
                    <div class="form-group mb-4">
                        <label for="country" class="control-label">{{ __('País') }}:</label>
                        <input type="text" id="country" name="country" class="form-control" value="Portugal" readonly required>
                    </div>

                    <!-- Campo Morada -->
                    <div class="form-group mb-4">
                        <label for="address" class="control-label">{{ __('Morada') }}:</label>
                        <input type="text" id="address" name="address" class="form-control" required>
                    </div>

                    <!-- Campo Código Postal -->
                    <div class="form-group mb-4">
                        <label for="postalCode" class="control-label">{{ __('Código Postal') }}:</label>
                        <input type="text" id="postalCode" name="postalCode" class="form-control" required>
                    </div>

                    <!-- Campo Telemóvel -->
                    <div class="form-group mb-4">
                        <label for="mobile" class="control-label">{{ __('Telemóvel') }}:</label>
                        <input type="text" id="mobile" name="mobile" class="form-control" required>
                    </div>

                    <!-- Botão de Enviar -->
                    <div class="text-center">
                        <button type="button" class="btn btn-success" onclick="createClient()">
                            <i class="fas fa-plus-circle"></i> {{ __('Criar Cliente') }}
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
                    <h5 class="modal-title" id="successModalLabel">{{ __('Cliente Criado com Sucesso') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ __('O cliente foi criado com sucesso!') }}
                </div>
                <div class="modal-footer">
                    <a href="{{ route('clientes.index') }}" class="btn btn-primary">{{ __('Voltar à Lista de Clientes') }}</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Perigo (Cliente Já Existe) -->
    <div class="modal fade" id="dangerModal" tabindex="-1" role="dialog" aria-labelledby="dangerModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="dangerModalLabel">{{ __('Erro ao Criar Cliente') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-danger">
                    {{ __('Já existe um cliente com esse NIF. Por favor, escolha um NIF diferente.') }}
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
            return data._token; 
        }

        // Função para carregar os usuários no dropdown
        async function loadUsers() {
            try {
                const response = await fetch('/get-users');
                const users = await response.json();

                const nameSelect = document.getElementById("name");

                // Preencher o dropdown com os usuários (exibindo nome e NIF na opção)
                users.forEach(user => {
                    const option = document.createElement("option");
                    option.value = user.name; // Guardar o ID do usuário
                    option.textContent = `${user.name} - ${user.nif}`; // Exibe nome e NIF na opção
                    option.dataset.nif = user.nif; // Armazena o NIF como dado na opção
                    option.dataset.telefone = user.telefone;
                    nameSelect.appendChild(option);
                });
            } catch (error) {
                console.error("Erro ao carregar os usuários:", error);
            }
        }

        // Função para preencher o campo NIF automaticamente ao selecionar um usuário
        function fillNIF() {
            const selectedUserId = document.getElementById("name").value;
            const selectedOption = document.querySelector(`#name option[value="${selectedUserId}"]`);

            // Preenche o campo NIF com o valor correspondente
            const selectedNIF = selectedOption ? selectedOption.dataset.nif : '';
            document.getElementById("nif").value = selectedNIF; // Preenche o NIF
            const selectedTelefone = selectedOption ? selectedOption.dataset.telefone : '';
            document.getElementById("mobile").value = selectedTelefone; // Preenche o NIF
        }

        async function createClient() {
            // Obtem os dados do formulário
            const name = document.getElementById("name").value;
            const country = document.getElementById("country").value;
            const vatNumber = document.getElementById("nif").value;
            const address = document.getElementById("address").value;
            const postalCode = document.getElementById("postalCode").value;
            const mobile = document.getElementById("mobile").value;

            // Configura os dados para enviar
            const urldata = new URLSearchParams();  
            urldata.append('name', name);
            urldata.append('country', country);
            urldata.append('vatNumber', vatNumber);
            urldata.append('address', address);
            urldata.append('postalCode', postalCode);
            urldata.append('mobile', mobile);

            try {
                const token = await getToken();  

                // Envia a requisição com o token obtido
                const response = await fetch(API_URL + "/clients", {
                    method: "POST",
                    headers: {
                        'Authorization': token, // Utiliza o token obtido
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: urldata
                });

                if (!response.ok) {
                    throw new Error(`Erro na requisição: ${response.status}`);
                }

                const data = await response.json();
                console.log("Cliente criado:", data);

                // Exibe o modal de sucesso
                $('#successModal').modal('show');
            } catch (error) {
                console.error("Erro ao criar cliente:", error);
                
                // Exibe o modal de erro (cliente já existe)
                $('#dangerModal').modal('show');
            }
        }

        // Carregar os usuários assim que a página carregar
        window.onload = loadUsers;
    </script>

    <!-- Scripts do Bootstrap para o modal -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
