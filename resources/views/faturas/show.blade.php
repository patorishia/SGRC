@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{__('Fatura Detalhes') }}</h1>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mt-4">
    <div id="invoice-details"></div> <!-- This will hold the details -->
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>

<script>
    const API_URL = "https://devipvc.gesfaturacao.pt/gesfaturacao/server/webservices/api/mobile/v1.0.2";  // Make sure this is your API URL
    let Mytoken = ""; // Variable to store the token

    // Function to fetch the token
    async function getToken() {
        try {
            const response = await fetch(API_URL + "/authentication", {
                method: "POST",
                headers: {
                    'Authorization': 'API Key',
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    username: "ipvc", // Replace with your username
                    password: "ipvc"  // Replace with your password
                })
            });

            if (!response.ok) {
                throw new Error(`Error fetching token: ${response.status}`);
            }

            const data = await response.json();
            Mytoken = data._token; // Store the token

            console.log("Token obtained:", Mytoken);
        } catch (error) {
            console.error("Error fetching token:", error);
        }
    }

    // Fetch the fatura details by ID
    async function fetchFaturaDetails(id) {
        if (!Mytoken) {
            await getToken(); // Get token if not already
        }

        try {
            const response = await fetch(`${API_URL}/invoices?id=${id}`, {
                method: "GET",
                headers: {
                    'Authorization': Mytoken // Use the token obtained
                }
            });

            if (!response.ok) {
                throw new Error(`Error fetching invoice details: ${response.status}`);
            }

            const data = await response.json();
            console.log("Invoice details fetched:", data);

            // Pass the fetched data to the display function
            displayFaturaDetails(data);

        } catch (error) {
            console.error("Error fetching invoice details:", error);
        }
    }

    // Function to display the fatura details
    function displayFaturaDetails(fatura) {
        const detailsDiv = document.getElementById('invoice-details');
        detailsDiv.innerHTML = ""; // Clear previous content

        if (!fatura || !fatura.result || Object.keys(fatura.result).length === 0) {
            detailsDiv.innerHTML = "<p>Fatura não encontrada.</p>";
            return;
        }

        const invoice = fatura.result;

        // Safeguard for client data
        const clientName = invoice.Cliente || "N/A";
        const clientAddress = invoice.EnderecoCliente || "N/A";
        const clientPostalCode = invoice.CodigoPostalCliente || "N/A";
        const clientCity = invoice.CidadeCliente || "N/A"; // Assuming there is a CidadeCliente field
        const clientEmail = invoice.EmailCliente || "N/A"; // Assuming there is an EmailCliente field

        // Determine the payment method using the getPaymentMethodClass function
        const selectedMethod = getPaymentMethodClass(invoice.MetodoPagamento);

        // Table for the line items
        let linesHTML = "";
        if (invoice.linhas && Array.isArray(invoice.linhas)) {
            linesHTML = invoice.linhas.map(line => {
                return ` 
                    <tr>
                        <td class="small">${line.qtd}</td>
                        <td class="small">${line.artigo}</td>
                        <td class="small">${line.tipo}</td>
                        <td class="small">${line.descricao}</td>
                        <td class="small">€${parseFloat(line.preco || 0).toFixed(2)}</td>
                    </tr>
                `;
            }).join('');
        }

        const detailsHTML = `
            <div class="invoice p-5 mb-5">
                <div class="row2">
                    <div class="col-12">
                        <h4 class="small">
                            <i class="fas fa-globe"></i> <span class="invoice-logo">SGRC</span>
                            <small class="float-right invoice-date">{{__('Data de Emissão:') }} ${invoice.Data}</small>
                        </h4>
                    </div>
                </div>
                <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">
                        {{__('De') }}
                        <address class="small">
                            <strong>SGRC</strong><br>
                            Praça Gen. Barbosa 44<br>
                            4900-347 Viana do Castelo<br>
                            sgrc@ipvc.pt
                        </address>
                    </div>
                    <div class="col-sm-4 invoice-col">
                        {{__('Para') }}
                        <address class="small">
                            <strong>${clientName}</strong><br>
                            ${clientAddress}<br>
                            ${clientPostalCode} ${clientCity}<br>
                            ${clientEmail}
                        </address>
                    </div>
                    <div class="col-sm-4 invoice-col">
                        <address class="small">
                            <b>{{__('ID Fatura:') }}</b> ${invoice.ID_Fatura}<br>
                            <b>{{__('ID Cliente:') }}</b> ${invoice.ID_Cliente}<br>
                            <b>{{__('Data de Expiração:') }}</b> ${invoice.Validade || "N/A"}
                        </address>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="small">{{__('Quantidade') }}</th>
                                    <th class="small">{{__('Codigo Produto') }}</th>
                                    <th class="small">{{__('Tipo') }} </th>
                                    <th class="small">{{__('Descrição') }}</th>
                                    <th class="small">{{__('Total') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${linesHTML} <!-- Display line items -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <h5>{{__('Métodos de Pagamento:') }}</h5>
                        <p>
                            <img src="{{ asset('images/nu.png') }}" alt="Nu" class="${selectedMethod === 'nu' ? '' : 'shadow'}">
                            <img src="{{ asset('images/MB.png') }}" alt="MB" class="${selectedMethod === 'mb' ? '' : 'shadow'}">
                            <img src="{{ asset('images/mbw.png') }}" alt="MBW" class="${selectedMethod === 'mbw' ? '' : 'shadow'}">
                            <img src="{{ asset('images/pp.png') }}" alt="Paypal" class="${selectedMethod === 'pp' ? '' : 'shadow'}">
                            <img src="{{ asset('images/cc.png') }}" alt="Credit Card" class="${selectedMethod === 'cc' ? '' : 'shadow'}">
                            <img src="{{ asset('images/another.png') }}" alt="Another" class="${selectedMethod === 'another' ? '' : 'shadow'}">
                        </p>
                                    
                        <div class="alert alert-light" style="background-color: #f8f9fa; border-color: #d6d8db; padding: 10px; display: inline-block;">
                            {{__('O método de pagamento atribuído para esta fatura é o seguinte:') }}
                            <strong class="text-uppercase">${invoice.MetodoPagamento || "N/A"}</strong>
                        </div>
                    </div>

                    <div class="col-6 text-left">
                        <h5>{{__('Preço Total a pagar até:') }} ${invoice.Validade || "N/A"}</h5>
                        <table class="table table-sm">
                            <tr>
                                <td>{{__('Preço:') }}</td>
                                <td>€${parseFloat(invoice.linhas.reduce((total, linha) => total + (parseFloat(linha.preco || 0)), 0)).toFixed(2)}</td> <!-- Sum of all preços -->
                            </tr>
                            <tr>
                                <td>{{__('Iva (23%):') }}</td>
                                <td>€${(parseFloat(invoice.linhas.reduce((total, linha) => total + (parseFloat(linha.preco || 0)), 0)) * 0.23).toFixed(2)}</td> <!-- Iva 23% of total Preço -->
                            </tr>
                            <tr>
                                <td><strong>{{__('Total:') }}</strong></td>
                                <td><strong>€${(parseFloat(invoice.linhas.reduce((total, linha) => total + (parseFloat(linha.preco || 0)), 0)) + (parseFloat(invoice.linhas.reduce((total, linha) => total + (parseFloat(linha.preco || 0)), 0)) * 0.23)).toFixed(2)}</strong></td> <!-- Total = Preço + Iva -->
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button class="btn btn-secondary float-left" onclick="window.print();">
                            <i class="fas fa-print"></i> {{__('Imprimir') }} 
                        </button>
                        <button class="btn btn-success float-right mr-2">
                            <i class="fas fa-credit-card"></i> {{__('Pagar') }}
                        </button>
                        <button class="btn btn-danger float-right mr-2" onclick="exportToPDF()">
                            <i class="fas fa-file-pdf"></i> {{__('Exportar para PDF') }}
                        </button>


                    </div>
                </div>
            </div>
        `;

        detailsDiv.innerHTML = detailsHTML;
    }

    // Function to determine the correct class for payment method
    function getPaymentMethodClass(metodoPagamento) {
        switch (metodoPagamento) {
            case 'Numerário':
                return 'nu';
            case 'MBWay':
                return 'mbw';
            case 'PayPal':
                return 'pp';
            case 'Referências de pagamento para Multibanco':
                return 'MB';
            case 'Cartão de crédito':
                return 'cc';
            default:
                return 'another';
        }
    }

    // Export the current content to PDF
   function exportToPDF() {
        const element = document.querySelector('.invoice'); // Get the invoice element
        const options = {
            margin: 0.5,
            filename: 'DetalhesFatura.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 4 },
            jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
        };

        // Generate and save the PDF
        html2pdf().from(element).set(options).save();
    }

    // Optionally, you can also ensure the script runs when the page is fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        // You can also log or set up event listeners if needed
        console.log('Document loaded, ready to export PDF.');
    });

    // Fetch the fatura details when the page loads
    window.onload = function() {
        const faturaId = @json($id); // Get the fatura ID passed from the controller
        fetchFaturaDetails(faturaId);
    };
</script>

<style>
    /* Your existing styles */
    .invoice .row2 {
        border-bottom: 1px solid #000; /* Add a line under the logo and date */
        padding-bottom: 10px;
    }

    .invoice .row2,
    .row.invoice-info,
    .row {
        margin-bottom: 20px;
    }

    .row .col-6 {
        padding: 0;
    }

    .table-sm td {
        padding: 5px 10px;
    }

    .invoice-logo {
        font-size: 25px;
    }

    .fas.fa-globe {
        font-size: 25px;
    }

    .invoice-date {
        font-size: 15px;
    }

    .invoice-col {
        padding: 0;
    }

    .highlight {
        border: 2px solid #4CAF50; /* Green border to highlight */
        box-shadow: 0 0 10px rgba(0, 255, 0, 0.5); /* Light green shadow */
    }

    /* Style for shadowing non-selected payment methods */
    img.shadow {
        opacity: 0.3; /* Reduce opacity */
        filter: grayscale(5%); /* Optional: make them grayscale */
    }
</style>

@endsection
