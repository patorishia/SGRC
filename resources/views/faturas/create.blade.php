@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Criação de Fatura') }}</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto mt-12 flex justify-center">
        <div class="card shadow-lg w-full max-w-2xl mt-4 rounded-lg">
            <div class="card-header bg-blue-600 text-black text-center py-4">
                <h3 class="card-title font-bold text-xl">{{ __('Formulário para Criação de Fatura') }}</h3>
            </div>

            <div class="card-body">
                <form id="invoiceForm">
                    @csrf

                    <!-- Campo Cliente -->
                    <div class="form-group mb-4">
                        <label for="client" class="control-label">{{ __('ID do Cliente Selecionado') }}:</label>
                        <input type="number" id="client" name="client" class="form-control" readonly required>
                    </div>
                    <!-- Seleção de Produtos -->
                    <button type="button" class="btn btn-primary" onclick="getAllClients()">{{ __('Ver Clientes') }}</button>
                    <div id="clientList" class="mt-4"></div>

                    <!-- Campo Série -->
                    <div class="form-group mb-4">
                        <label for="serie" class="control-label">{{ __('Série') }}:</label>
                        <select id="serie" name="serie" class="form-control" required>
                            <!-- The options will be dynamically populated by the getSeries() function -->
                        </select>
                    </div>


                    <!-- Campo Data -->
                    <div class="form-group mb-4">
                        <label for="date" class="control-label">{{ __('Data') }}:</label>
                        <input type="date" id="date" name="date" class="form-control" required>
                    </div>

                    <!-- Campo Data de Vencimento -->
                    <div class="form-group mb-4">
                        <label for="expiration" class="control-label">{{ __('Data de Vencimento') }}:</label>
                        <input type="date" id="expiration" name="expiration" class="form-control" required>
                    </div>

                    <!-- Seleção de Produtos -->
                    <button type="button" class="btn btn-primary" onclick="toggleProductList()">{{ __('Ver Produtos') }}</button>


                    <div id="productList" class="mt-4"></div>

                    <!-- Linhas da Fatura -->
                    <div class="form-group mb-4">
                        <label for="lines" class="control-label">{{ __('Linhas da Fatura') }}:</label>
                        <textarea id="lines" name="lines" class="form-control" readonly placeholder="{{ __('Produtos selecionados aparecerão aqui') }}"></textarea>
                    </div>

                   <!-- Campo Moeda -->
<div class="form-group mb-4">
    <label for="coin" class="control-label">{{ __('Moeda') }}:</label>
    <select id="coin" name="coin" class="form-control" required>
        <!-- As opções serão preenchidas dinamicamente pela função getSeries() -->
    </select>
</div>

<div class="form-group mb-4">
    <label for="payment" class="control-label">{{ __('Método de Pagamento') }}:</label>
    <select id="payment" name="payment" class="form-control" required>
        <!-- As opções serão preenchidas dinamicamente pela função getSeries() -->
    </select>
</div>

<div class="text-center">
    <button type="button" class="btn btn-success" onclick="createInvoice()">
        <i class="fas fa-plus-circle"></i> {{ __('Criar Fatura') }}
    </button>
</div>
</form>
</div>
</div>
</div>

<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="successModalLabel">{{ __('Fatura Criada com Sucesso') }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            {{ __('A fatura foi criada com sucesso!') }}
        </div>
        <div class="modal-footer">
            <a href="{{ url('/faturas') }}" class="btn btn-primary">{{ __('Voltar à Lista de Faturas') }}</a>
        </div>
    </div>
</div>
</div>

<!-- Modal de Erro -->
<div class="modal fade" id="dangerModal" tabindex="-1" role="dialog" aria-labelledby="dangerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger" id="dangerModalLabel">{{ __('Erro ao Criar Fatura') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-danger">
                {{ __('Erro ao criar fatura. Verifique os dados e tente novamente.') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Fechar') }}</button>
            </div>
        </div>
    </div>
</div>

<script>
    const API_URL = "https://devipvc.gesfaturacao.pt/gesfaturacao/server/webservices/api/mobile/v1.0.2";
    let productsLoaded = false;

    // Função para alternar a visibilidade da lista de produtos
    function toggleProductList() {
        const productListDiv = document.getElementById("productList");

        // Se os produtos ainda não estiverem carregados, busque-os
        if (!productsLoaded) {
            getAllProducts();
            productsLoaded = true;  // Marca os produtos como carregados
        }

        // Alterna a visibilidade da lista de produtos
        if (productListDiv.style.display === "none" || productListDiv.style.display === "") {
            productListDiv.style.display = "block";  // Exibe a lista de produtos
        } else {
            productListDiv.style.display = "none";  // Esconde a lista de produtos
        }
    }

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

    // Função para obter todos os clientes
    async function getAllClients() {
        try {
            const token = await getToken();
            const uniqueNifs = [...new Set(userNifs)]; // Remove duplicatas
            const nifsParam = uniqueNifs.join(','); 

            const response = await fetch(`${API_URL}/clients?nif=${encodeURIComponent(nifsParam)}`, {
                method: "GET",
                headers: {
                    'Authorization': token
                }
            });

            if (!response.ok) {
                throw new Error(`Erro na requisição: ${response.status}`);
            }

            const data = await response.json();

            // Filtra os clientes onde vatNumber corresponde a um dos userNifs
            const filteredClients = data.data.filter(client => uniqueNifs.includes(client.vatNumber));

            displayClients(filteredClients);
        } catch (error) {
            console.error("Erro ao obter clientes:", error);
        }
    }

    const userNifs = @json($userNifs) || [];

    console.log(userNifs);

    function displayClients(clients) {
        const clientListDiv = document.getElementById("clientList");
        clientListDiv.innerHTML = ""; 

        if (clients.length === 0) {
            clientListDiv.innerHTML = "<p>Nenhum cliente encontrado.</p>";
            return;
        }

        const select = document.createElement("select");
        select.id = "clientDropdown";

        const defaultOption = document.createElement("option");
        defaultOption.value = "";
        defaultOption.textContent = "{{__('Selecione um cliente') }}";
        select.appendChild(defaultOption);

        clients.forEach(client => {
            const option = document.createElement("option");
            option.value = client.id;
            option.textContent = `${client.name} (NIF: ${client.vatNumber})`;
            select.appendChild(option);
        });

        select.onchange = () => {
            document.getElementById("client").value = select.value;
        };

        clientListDiv.appendChild(select);
    }

    // Função para obter todos os produtos
    async function getAllProducts() {
        try {
            const token = await getToken();
            const response = await fetch(API_URL + "/products", {
                method: "GET",
                headers: {
                    'Authorization': token
                }
            });

            if (!response.ok) {
                throw new Error(`Erro na requisição: ${response.status}`);
            }

            const data = await response.json();
            displayProducts(data.data);

        } catch (error) {
            console.error("Erro ao obter produtos:", error);
        }
    }

    // Função para exibir os produtos em uma tabela
    function displayProducts(products) {
        const productListDiv = document.getElementById("productList");
        productListDiv.innerHTML = "";

        // Filtra os produtos com código começando com "SGRC"
        const filteredProducts = products.filter(product => product.code.startsWith("SGRC"));

        if (filteredProducts.length === 0) {
            productListDiv.innerHTML = "<p>Nenhum produto encontrado com o código começando com 'SGRC'.</p>";
            return;
        }

        const table = document.createElement("table");
        filteredProducts.forEach(product => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${product.id}</td>
                <td>${product.description}</td>
                <td>${product.price}</td>
                <td><button onclick='addProductToLines(${JSON.stringify(product)})'>{{__('Adicionar') }}</button></td>
            `;
            table.appendChild(row);
        });

        productListDiv.appendChild(table);
    }

    // Função para buscar métodos de pagamento da API
    async function getPaymentMethods() {
        try {
            const token = await getToken();  // Obtem o token para autenticação
            const response = await fetch(API_URL + "/payment-methods", {
                method: "GET",
                headers: {
                    'Authorization': token
                }
            });

            if (!response.ok) {
                throw new Error(`Erro na requisição: ${response.status}`);
            }

            const data = await response.json();
            displayPaymentMethods(data.data);  // Passa os dados dos métodos de pagamento para uma função de exibição
        } catch (error) {
            console.error("Erro ao obter métodos de pagamento:", error);
        }
    }

    // Função para exibir os métodos de pagamento no dropdown
    function displayPaymentMethods(paymentMethods) {
        const paymentField = document.getElementById("payment");
        paymentField.innerHTML = "";  // Limpa as opções existentes

        // Adiciona uma opção padrão
        const defaultOption = document.createElement("option");
        defaultOption.value = "";
        defaultOption.textContent = "{{__('Selecione um método de pagamento') }}";
        paymentField.appendChild(defaultOption);

        // Popula o dropdown com os métodos de pagamento
        paymentMethods.forEach(method => {
            const option = document.createElement("option");
            option.value = method.id;  // Assume que `id` é o identificador único
            option.textContent = method.description;  // Exibe a descrição do método de pagamento
            paymentField.appendChild(option);
        });
    }

    // Chama a função para buscar e exibir os métodos de pagamento
    getPaymentMethods();

    // Função para adicionar o produto nas linhas da fatura
    function addProductToLines(product) {
        const linesField = document.getElementById("lines");
        let lines = JSON.parse(linesField.value || "[]");

        // Adicionando os campos faltantes
        const productLine = {
            id: product.id,
            description: product.description,
            quantity: 1,       // Quantidade padrão
            price: parseFloat(product.price).toFixed(2),  // Garante o formato correto para o preço
            discount: 0,       // Desconto padrão
            tax: 2,            // Taxa padrão (alterar conforme necessário)
            exemption: 0,      // Isenção padrão
            retention: 0       // Retenção padrão
        };

        lines.push(productLine);
        linesField.value = JSON.stringify(lines, null, 2); // Formatação legível

        // Esconde a lista de produtos após selecionar um
        document.getElementById("productList").style.display = "none";
    }

    // Função para buscar séries da API
    async function getSeries() {
        try {
            const token = await getToken();
            const response = await fetch(API_URL + "/series", {
                method: "GET",
                headers: {
                    'Authorization': token
                }
            });

            if (!response.ok) {
                throw new Error(`Erro na requisição: ${response.status}`);
            }

            const data = await response.json();
            displaySeries(data.data); // Passa os dados das séries para uma função de exibição

        } catch (error) {
            console.error("Erro ao obter séries:", error);
        }
    }

    // Função para exibir as séries no dropdown
    function displaySeries(series) {
        const serieField = document.getElementById("serie");
        serieField.innerHTML = ""; // Limpa as opções existentes

        // Adiciona uma opção padrão
        const defaultOption = document.createElement("option");
        defaultOption.value = "";
        defaultOption.textContent = "{{__('Selecione uma série') }}";
        serieField.appendChild(defaultOption);

        // Popula o dropdown com as séries
        series.forEach(serie => {
            const option = document.createElement("option");
            option.value = serie.id;
            option.textContent = serie.description;
            serieField.appendChild(option);
        });
    }

    // Chama a função para obter e exibir as séries
    getSeries();

    // Função para obter moedas da API
    async function getCoins() {
        try {
            const token = await getToken();
            const response = await fetch(API_URL + "/coins", {
                method: "GET",
                headers: {
                    'Authorization': token
                }
            });

            if (!response.ok) {
                throw new Error(`Erro na requisição: ${response.status}`);
            }

            const data = await response.json();
            displayCoins(data.data); // Passa os dados das moedas para a função de exibição

        } catch (error) {
            console.error("Erro ao obter moedas:", error);
        }
    }

    // Função para exibir as moedas no dropdown
    function displayCoins(coins) {
        const coinField = document.getElementById("coin");
        coinField.innerHTML = ""; // Limpa as opções existentes

        // Adiciona uma opção padrão
        const defaultOption = document.createElement("option");
        defaultOption.value = "";
        defaultOption.textContent = "{{__('Selecione uma moeda') }}";
        coinField.appendChild(defaultOption);

        // Popula o dropdown com as moedas
        coins.forEach(coin => {
            const option = document.createElement("option");
            option.value = coin.id; // Assume que `id` é o identificador único
            option.textContent = `${coin.description} (${coin.symbol})`; // Exibe descrição e símbolo
            coinField.appendChild(option);
        });
    }

    // Chama a função para buscar e exibir as moedas
    getCoins();

    async function createInvoice() {
        const client = document.getElementById("client").value;
        const serie = document.getElementById("serie").value;
        const date = document.getElementById("date").value;
        const expiration = document.getElementById("expiration").value;
        const lines = document.getElementById("lines").value;
        const coin = document.getElementById("coin").value;
        const payment = document.getElementById("payment").value;

        // Verificar e formatar as datas no formato correto
        const formatDate = (dateStr) => {
            const [year, month, day] = dateStr.split("-");
            return `${day}/${month}/${year}`;
        };

        const formattedDate = formatDate(date);
        const formattedExpiration = formatDate(expiration);

       
        let linesData;
        try {
            linesData = JSON.parse(lines).map(line => ({
                ...line,
                quantity: String(line.quantity),
                price: String(line.price),
                discount: String(line.discount),
                tax: line.tax, 
                exemption: String(line.exemption),
                retention: String(line.retention),
            }));
        } catch (error) {
            console.error("Erro ao analisar as linhas:", error);
            alert("Erro nas linhas da fatura.");
            return;
        }

        // Corpo da requisição formatado
        const urldata = new URLSearchParams();
        urldata.append("client", client);
        urldata.append("serie", serie);
        urldata.append("date", formattedDate);
        urldata.append("expiration", formattedExpiration);
        urldata.append("lines", JSON.stringify(linesData));
        urldata.append("number", "0");
        urldata.append("coin", coin);
        urldata.append("payment", payment);
        urldata.append("finalizarDocumento", "true");

        try {
            const token = await getToken();
            const response = await fetch(API_URL + "/invoices", {
                method: "POST",
                headers: {
                    "Authorization": token,
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: urldata,
            });

            if (!response.ok) {
                const errorData = await response.json();
                console.error("Erro ao criar fatura:", errorData);
                alert("Erro ao criar fatura. Veja os detalhes no console.");
                return;
            }

            const data = await response.json();
            $('#successModal').modal('show');
            console.log(data);
        } catch (error) {
            console.error("Erro ao criar fatura:", error);
            alert("Erro ao criar fatura.");
        }
    }
</script>
@endsection
