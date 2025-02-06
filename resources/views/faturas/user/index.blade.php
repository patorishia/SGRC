@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Minhas Faturas') }}</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mt-4">
        <div class="row">
            <!-- Tabela de faturas -->
            <div class="col-12">
                <div id="invoiceList"></div>
            </div>
        </div>
    </div>
   
    @if(auth()->user()->role === 'admin')
    <div class="col-12 text-center mt-4">
        <a href="/faturas/create" class="btn btn-success">
            <i class="fas fa-plus-circle"></i> {{ __('Criar Fatura') }}
        </a>
    </div>
    @endif

    <!-- Modal de confirmação de exclusão -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">{{ __('Confirmar Exclusão') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{ __('Tem certeza que deseja excluir esta fatura?') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancelar') }}</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">{{ __('Excluir') }}</button>
                </div>
            </div>
        </div>
    </div>
    <script>
    const API_URL = "https://devipvc.gesfaturacao.pt/gesfaturacao/server/webservices/api/mobile/v1.0.2";
    let Mytoken = ""; // Variável para armazenar o token
    let validUserNames = []; // Array para armazenar os nomes de utilizadores válidos
    let selectedInvoiceId = null; // Variável para armazenar o ID da fatura selecionada para exclusão
    let userNif = ""; // Variável para armazenar o NIF do utilizador autenticado
    const userRole = "{{ auth()->user()->role }}";

    // Função para obter o token
    async function getToken() {
        try {
            const response = await fetch(API_URL + "/authentication", {
                method: "POST",
                headers: {
                    'Authorization': 'API Key', 
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    username: "ipvc", // Utilizador
                    password: "ipvc"  
                })
            });

            if (!response.ok) {
                throw new Error(`Erro ao obter o token: ${response.status}`);
            }

            const data = await response.json();
            Mytoken = data._token; // Armazenar o token

            console.log("Token obtido:", Mytoken);
        } catch (error) {
            console.error("Erro ao obter o token:", error);
        }
    }

    // Obter todos os nomes de utilizadores da base de dados
    async function getUserNames() {
        try {
            const response = await fetch('/users/names');
            if (!response.ok) {
                throw new Error(`Erro ao obter os nomes dos utilizadores: ${response.status}`);
            }

            validUserNames = await response.json(); // Armazenar os nomes dos utilizadores em um array
            console.log("Nomes válidos dos utilizadores:", validUserNames);
        } catch (error) {
            console.error("Erro ao obter os nomes dos utilizadores:", error);
        }
    }

    // Obter o NIF do utilizador autenticado (Assumindo que está disponível na sessão do utilizador)
    async function getUserNif() {
        try {
            const response = await fetch('/user/nif'); // Endpoint que retorna o NIF do utilizador
            if (!response.ok) {
                throw new Error(`Erro ao obter o NIF do utilizador: ${response.status}`);
            }

            const data = await response.json();
            userNif = data.nif; // Armazenar o NIF do utilizador

            console.log("NIF do utilizador:", userNif);  // Exibir o NIF no console
        } catch (error) {
            console.error("Erro ao obter o NIF do utilizador:", error);
        }
    }

    // Função para obter todas as faturas
    async function getAllInvoices() {
        if (!Mytoken) {
            await getToken(); // Obter token se ainda não tiver sido obtido
        }

        if (!validUserNames.length) {
            await getUserNames(); // Obter os nomes dos utilizadores se ainda não tiverem sido obtidos
        }

        await getUserNif();  // Obter o NIF do utilizador

        try {
            const response = await fetch(API_URL + "/invoices", {
                method: "GET",
                headers: {
                    'Authorization': Mytoken // Utilizar o token obtido
                }
            });

            if (!response.ok) {
                throw new Error(`Erro ao obter as faturas: ${response.status}`);
            }

            const data = await response.json();
            console.log("Faturas obtidas:", data);

            // Filtrar faturas onde o número de NIF corresponde ao NIF do utilizador autenticado
            const filteredInvoices = data.data.filter(invoice => 
                invoice.vatNumber === userNif // Filtrar com base no NIF
            );

            console.log("Faturas filtradas:", filteredInvoices);  // Exibir faturas filtradas

            // Exibir as faturas filtradas
            displayInvoices(filteredInvoices);

        } catch (error) {
            console.error("Erro ao obter as faturas:", error);
        }
    }

    // Função para exibir as faturas
    function displayInvoices(invoices) {
        const invoiceListDiv = document.getElementById("invoiceList");
        invoiceListDiv.innerHTML = ""; // Limpar o conteúdo anterior

        if (invoices.length === 0) {
            invoiceListDiv.innerHTML = "<p>Não foram encontradas faturas.</p>";
            return;
        }

        const table = document.createElement("table");
        table.classList.add("table", "table-striped", "table-bordered");

        // Cabeçalho da tabela
        const thead = document.createElement("thead");
        const headerRow = document.createElement("tr");
        ["ID", "Data", "Cliente", "Total (€)", "Ações"].forEach(text => {
            const th = document.createElement("th");
            th.textContent = text;
            th.classList.add("bg-gray", "text-white");
            headerRow.appendChild(th);
        });
        thead.appendChild(headerRow);
        table.appendChild(thead);

        // Corpo da tabela
        const tbody = document.createElement("tbody");
        invoices.forEach(invoice => {
            const row = document.createElement("tr");

            const dataFields = [
                invoice.id, 
                invoice.dateFormatted || invoice.date, // Usar a data formatada se disponível
                invoice.name || "N/A", // Nome do cliente
                parseFloat(invoice.total || 0).toFixed(2) // Total formatado
            ];

            dataFields.forEach(value => {
                const td = document.createElement("td");
                td.textContent = value;
                row.appendChild(td);
            });

            // Criar botões de ação (Ver, Editar e Excluir)
            const actionsTd = document.createElement("td");
            actionsTd.classList.add("text-center");

            // Botão de visualização (Ícone azul de olho)
            const viewButton = document.createElement("button");
            viewButton.classList.add("btn", "btn-info", "btn-sm");
            viewButton.innerHTML = '<i class="fas fa-eye"></i>';
            viewButton.onclick = () => window.location.href = `/faturas/${invoice.id}`;

            // Adicionar condicionalmente os botões Editar e Excluir apenas se o utilizador for um administrador
            if (userRole === 'admin') {
                const editButton = document.createElement("button");
                editButton.classList.add("btn", "btn-primary", "btn-sm", "ml-2");
                editButton.innerHTML = '<i class="fas fa-edit"></i>';
                editButton.onclick = () => window.location.href = `/faturas/edit/${invoice.id}`; // Redirecionar para a página de edição

                const deleteButton = document.createElement("button");
                deleteButton.classList.add("btn", "btn-danger", "btn-sm", "ml-2");
                deleteButton.innerHTML = '<i class="fas fa-trash"></i>';
                deleteButton.onclick = () => openDeleteModal(invoice.id); // Chamar função para abrir modal de exclusão

                actionsTd.appendChild(editButton);
                actionsTd.appendChild(deleteButton);
            }

            actionsTd.appendChild(viewButton);
            row.appendChild(actionsTd);

            tbody.appendChild(row);
        });
        table.appendChild(tbody);
        invoiceListDiv.appendChild(table);
    }

    // Função para abrir o modal de confirmação de exclusão
    function openDeleteModal(invoiceId) {
        selectedInvoiceId = invoiceId;
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }

    // Função para excluir uma fatura
    async function deleteInvoice() {
        try {
            const response = await fetch(API_URL + "/invoices/" + selectedInvoiceId, {
                method: "DELETE",
                headers: {
                    'Authorization': Mytoken // Utilizar o token obtido
                }
            });

            if (!response.ok) {
                throw new Error(`Erro ao excluir a fatura: ${response.status}`);
            }

            alert("Fatura excluída com sucesso.");
            getAllInvoices(); // Atualizar a lista de faturas após exclusão
            const modal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
            modal.hide(); // Fechar o modal após a exclusão
        } catch (error) {
            console.error("Erro ao excluir a fatura:", error);
        }
    }

    // Confirmar exclusão ao clicar no botão de exclusão no modal
    document.getElementById('confirmDeleteBtn').addEventListener('click', deleteInvoice);

    // Chamar getAllInvoices quando a página for carregada
    window.onload = getAllInvoices;
</script>

@endsection
