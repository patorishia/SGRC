@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Produtos/Renda') }}</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mt-4">
        <div class="row">
            <!-- Tabela de produtos -->
            <div class="col-12">
                <div id="productList"></div>
            </div>

            <!-- Botão para criar um novo produto -->
            <div class="col-12 text-center mt-4">
                <a href="/produtos/create" class="btn btn-success">
                    <i class="fas fa-plus-circle"></i> {{ __('Criar Produto/Renda') }}
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
                    {{ __('Tem certeza que deseja excluir este produto?') }}
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
        let selectedProductId = null; 

        async function getToken() {
            const response = await fetch(API_URL + "/authentication", {
                method: "POST",
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ username: "ipvc", password: "ipvc" })
            });
            const data = await response.json();
            return data._token;
        }

        async function getAllProducts() {
            try {
                const token = await getToken();
                const response = await fetch(API_URL + "/products", {
                    method: "GET",
                    headers: { 'Authorization': token }
                });

                if (!response.ok) throw new Error(`Erro na requisição: ${response.status}`);

                const data = await response.json();
                displayProducts(data.data);
            } catch (error) {
                console.error("Erro ao obter produtos:", error);
            }
        }

        function displayProducts(products) {
            const productListDiv = document.getElementById("productList");
            productListDiv.innerHTML = "";

            // Filtra os produtos para mostrar apenas os que começam com "SGRC" no código
            const filteredProducts = products.filter(product => product.code && product.code.startsWith("SGRC"));

            if (filteredProducts.length === 0) {
                productListDiv.innerHTML = "<p>{{ __('Nenhum produto encontrado com o código começando com \'SGRC\'.') }}</p>";
                return;
            }

            const table = document.createElement("table");
            table.classList.add("table", "table-striped", "table-bordered");

            const thead = document.createElement("thead");
            const headerRow = document.createElement("tr");
            ["ID", "Nome", "Código", "Preço sem IVA(€)", "Preço com IVA(€)", "Ações"].forEach(text => {
                const th = document.createElement("th");
                th.textContent = text;
                th.classList.add("bg-gray", "text-white");
                headerRow.appendChild(th);
            });
            thead.appendChild(headerRow);
            table.appendChild(thead);

            const tbody = document.createElement("tbody");
            filteredProducts.forEach(product => {
                const row = document.createElement("tr");

                // Criar células para os produtos
                ["id", "description", "code", "price", "pricePvp"].forEach(key => { 
                    const td = document.createElement("td");
                    td.textContent = product[key];
                    row.appendChild(td);
                });

                // Adiciona botões de "Excluir" e "Editar"
                const actionsTd = document.createElement("td");
                actionsTd.classList.add("text-center");

                // Botão de Editar (redireciona para a página de edição)
                const editButton = document.createElement("button");
                editButton.classList.add("btn", "btn-info", "btn-sm");
                editButton.onclick = () => window.location.href = `/produtos/${product.id}/edit`;
                const editIcon = document.createElement("i");
                editIcon.classList.add("fas", "fa-edit");
                editButton.appendChild(editIcon);
                actionsTd.appendChild(editButton);

                // Botão de Excluir (exibe o modal de confirmação)
                const deleteButton = document.createElement("button");
                deleteButton.classList.add("btn", "btn-danger", "btn-sm", "ml-2");
                deleteButton.onclick = () => openDeleteModal(product.id); 
                const trashIcon = document.createElement("i");
                trashIcon.classList.add("fas", "fa-trash-alt");
                deleteButton.appendChild(trashIcon);
                actionsTd.appendChild(deleteButton);

                row.appendChild(actionsTd);
                tbody.appendChild(row);
            });
            table.appendChild(tbody);
            productListDiv.appendChild(table);
        }

        // Função para abrir o modal de confirmação de exclusão
        function openDeleteModal(productId) {
            selectedProductId = productId; 
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        }

        // Função para excluir o produto após confirmação no modal
        async function deleteProduct() {
            try {
                const token = await getToken();
                const response = await fetch(`${API_URL}/products/${product.id}`, {
                    method: "DELETE",
                    headers: { 
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json'
                    }
                });

                if (!response.ok) {
                    alert("Erro ao excluir produto! Tente novamente.");
                    return;
                }

                alert("Produto excluído com sucesso!");
                location.reload(); // Recarregar a lista de produtos
            } catch (error) {
                console.error("Erro ao excluir produto:", error);
                alert("Erro ao excluir produto! Tente novamente.");
            }
        }

        // Ao clicar no botão "Excluir" no modal, chama a função de exclusão
        document.getElementById('confirmDeleteBtn').addEventListener('click', deleteProduct);

        // Carregar os produtos ao carregar a página
        window.onload = getAllProducts;
    </script>
@endsection
