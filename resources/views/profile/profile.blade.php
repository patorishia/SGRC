@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ __('Meu Perfil') }}</h1>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-12">
            <!-- Cartão único para informações do perfil -->
            <div class="card shadow-lg">
                <div class="card-header text-center bg-blue-600 text-black py-4">
                    <h3 class="card-title font-bold text-xl">{{ __('Detalhes do Perfil') }}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Seção de Imagem de Perfil (Esquerda) -->
                            <div class="col-md-4 text-center position-relative">
                                @if(Auth::user()->profileImage)
                                    <img src="{{ asset('storage/profileImages/' . Auth::user()->profileImage) }}" alt="Imagem de Perfil" class="img-fluid rounded-circle" id="profileImagePreview" style="object-fit: cover; width: 150px; height: 150px;">
                                @else
                                    <p>{{ __('Não há imagem de perfil disponível') }}</p>
                                @endif
                                <div class="mt-3">
                                    <!-- Input de arquivo oculto -->
                                    <input type="file" name="profileImage" id="profileImage" class="d-none" accept="image/*" onchange="this.form.submit()">
                                    <!-- Botão personalizado com ícone de editar -->
                                    <label for="profileImage" class="btn btn-primary position-absolute" style="bottom: 10px; left: 50%; transform: translateX(-50%);">
                                        <i class="fas fa-edit"></i> 
                                    </label>
                                </div>
                            </div>

                            <!-- Seção de informações editáveis (Direita) -->
                            <div class="col-md-8">
                                <!-- Seção de Nome (Editável) -->
                                <div class="form-group row mb-4">
                                    <label for="name" class="col-md-4 col-form-label">{{ __('Nome') }}</label>
                                    <div class="col-md-8">
                                        <input type="text" name="name" id="name" class="form-control" value="{{ auth()->user()->name }}" required>
                                    </div>
                                </div>

                                <!-- Seção de Email (Editável) -->
                                <div class="form-group row mb-4">
                                    <label for="email" class="col-md-4 col-form-label">{{ __('Email') }}</label>
                                    <div class="col-md-8">
                                        <input type="email" name="email" id="email" class="form-control" value="{{ auth()->user()->email }}" required>
                                    </div>
                                </div>

                                <!-- Seção de Telefone (Editável) -->
                                <div class="form-group row mb-4">
                                    <label for="telefone" class="col-md-4 col-form-label">{{ __('Telefone') }}</label>
                                    <div class="col-md-8">
                                        <input type="text" name="telefone" id="telefone" class="form-control" value="{{ auth()->user()->telefone }}" required>
                                    </div>
                                </div>

                                <!-- Seção Data de Criação (Somente Leitura) -->
                                <div class="form-group row mb-4">
                                    <label for="created_at" class="col-md-4 col-form-label">{{ __('Data de Criação') }}</label>
                                    <div class="col-md-8">
                                        <input type="text" name="created_at" id="created_at" class="form-control" value="{{ auth()->user()->created_at->format('d/m/Y H:i') }}" readonly>
                                    </div>
                                </div>

                                <!-- Seção de Nome do Condomínio (Somente Leitura) -->
                                <div class="form-group row mb-4">
                                    <label for="condominio" class="col-md-4 col-form-label">{{ __('Condomínio') }}</label>
                                    <div class="col-md-8">
                                        <input type="text" name="condominio" id="condominio" class="form-control" value="{{ auth()->user()->condominio ? auth()->user()->condominio->name : '' }}" readonly>

                                    </div>
                                </div>

                                <!-- Seção NIF (Somente Leitura) -->
                                <div class="form-group row mb-4">
                                    <label for="nif" class="col-md-4 col-form-label">{{ __('NIF') }}</label>
                                    <div class="col-md-8">
                                        <input type="text" name="nif" id="nif" class="form-control" value="{{ auth()->user()->nif }}" readonly>
                                    </div>
                                </div>

                                <!-- Seção Número de Reclamações (Somente Leitura) -->
                                <div class="form-group row mb-4">
                                    <label for="reclamacoes" class="col-md-4 col-form-label">{{ __('Número de Reclamações') }}</label>
                                    <div class="col-md-8">
                                        <input type="text" name="reclamacoes" id="reclamacoes" class="form-control" value="{{ auth()->user()->reclamacoes->count() }}" readonly>
                                    </div>
                                </div>

                                <!-- Botão de Salvar -->
                                <div class="form-group row">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-save"></i> {{ __('Salvar Alterações') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Exibe automaticamente a imagem de visualização e envia o formulário quando um arquivo é selecionado
    document.getElementById('profileImage').addEventListener('change', function() {
        var reader = new FileReader();
        reader.onload = function (e) {
            // Exibe a imagem selecionada como pré-visualização
            document.getElementById('profileImagePreview').src = e.target.result;
        }
        reader.readAsDataURL(this.files[0]);
    });
</script>
@endsection
