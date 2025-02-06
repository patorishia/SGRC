@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ __('Clientes') }}</h1>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mt-4">
    <div class="row">
        <!-- Tabela de clientes -->
        <div class="col-12">
            <div id="clientList"></div>
        </div>

        <!-- Botão para criar um novo cliente -->
        <div class="col-12 text-center mt-4">
            <a href="/clientes/create" class="btn btn-success">
                <i class="fas fa-plus-circle"></i> {{ __('Criar Cliente') }}
            </a>
        </div>
    </div>
</div>

<!-- Modal de confirmação de exclusão -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">{{ __('Confirmar Exclusão') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ __('Tem certeza que deseja excluir este cliente?') }}
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
    let selectedClientId = null; // Variável para armazenar o ID do cliente selecionado para eliminação
    const allowedNIFs = @json($nifList); // Lista de NIFs da base de dados

    async function getToken() {
        const response = await fetch(API_URL + "/authentication", {
            method: "POST",
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ username: "ipvc", password: "ipvc" })
        });
        const data = await response.json();
        return data._token;
    }

    async function getAllClients() {
        try {
            const token = await getToken();
            const response = await fetch(API_URL + "/clients", {
                method: "GET",
                headers: { 'Authorization': token }
            });

            if (!response.ok) throw new Error(`Erro na requisição: ${response.status}`);

            const data = await response.json();
            displayClients(data.data);
        } catch (error) {
            console.error("Erro ao obter clientes:", error);
        }
    }

    function displayClients(clients) {
        const clientListDiv = document.getElementById("clientList");
        clientListDiv.innerHTML = "";

        const filteredClients = clients.filter(client => allowedNIFs.includes(client.vatNumber));

        if (filteredClients.length === 0) {
            clientListDiv.innerHTML = "<p>{{ __('Nenhum cliente encontrado.') }}</p>";
            return;
        }

        const table = document.createElement("table");
        table.classList.add("table", "table-striped", "table-bordered");

        const thead = document.createElement("thead");
        const headerRow = document.createElement("tr");
        ["ID", "Nome", "Morada", "Nif", "Ações"].forEach(text => {
            const th = document.createElement("th");
            th.textContent = text;
            th.classList.add("bg-gray", "text-white");
            headerRow.appendChild(th);
        });
        thead.appendChild(headerRow);
        table.appendChild(thead);

        const tbody = document.createElement("tbody");
        filteredClients.forEach(client => {
            const row = document.createElement("tr");

            ["id", "name", "address", "vatNumber"].forEach(key => {
                const td = document.createElement("td");
                td.textContent = client[key] || "N/A";
                row.appendChild(td);
            });

            const actionsTd = document.createElement("td");
            actionsTd.classList.add("text-center");

            // Botão Editar
            const editButton = document.createElement("button");
            editButton.classList.add("btn", "btn-info", "btn-sm");
            editButton.onclick = () => window.location.href = `/clientes/${client.id}/edit`;
            const editIcon = document.createElement("i");
            editIcon.classList.add("fas", "fa-edit");
            editButton.appendChild(editIcon);
            actionsTd.appendChild(editButton);

            // Botão Apagar
            const deleteButton = document.createElement("button");
            deleteButton.classList.add("btn", "btn-danger", "btn-sm", "ml-2");
            deleteButton.onclick = () => openDeleteModal(client.id);
            const trashIcon = document.createElement("i");
            trashIcon.classList.add("fas", "fa-trash-alt");
            deleteButton.appendChild(trashIcon);
            actionsTd.appendChild(deleteButton);

            row.appendChild(actionsTd);
            tbody.appendChild(row);
        });
        table.appendChild(tbody);
        clientListDiv.appendChild(table);
    }
    
    // Abrir modal de eliminação
    function openDeleteModal(clientId) {
        selectedClientId = clientId;
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }

    // Eliminar cliente
    async function deleteClient() {
        try {
            // Obter o token e registá-lo
            const token = await getToken();
            console.log("Token:", token);

            const url = `${API_URL}/clients/${selectedClientId}`;
            console.log("URL de DELETE:", url);

            const response = await fetch(url, {
                method: "DELETE",
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            });

            // Registar o status e corpo da resposta
            const responseBody = await response.json();
            console.log("Status da resposta:", response.status);
            console.log("Corpo da resposta:", responseBody);

            if (!response.ok) {
                alert("{{ __('Erro ao eliminar cliente! Tente novamente.') }}");
                return;
            }

            alert("{{ __('Cliente eliminado com sucesso!') }}");
            location.reload(); // Recarregar a página após a eliminação com sucesso
        } catch (error) {
            console.error("Erro ao eliminar cliente:", error);
            alert("{{ __('Erro ao eliminar cliente! Tente novamente.') }}");
        }
    }

    // Confirmar eliminação no modal
    document.getElementById('confirmDeleteBtn').addEventListener('click', deleteClient);

    window.onload = getAllClients;
</script>
    @endsection
