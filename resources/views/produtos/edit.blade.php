@extends('layouts.app')

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
    
<div class="container mx-auto mt-12 flex justify-center">
        <div class="card shadow-lg w-full max-w-2xl mt-4 rounded-lg">
            <div class="card-header bg-blue-600 text-black text-center py-4">
        <h3 class="card-title font-bold text-xl ">{{ __('Editar Produto/Renda') }}</h3>
        </div>

        <div class="card-body">
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('produtos.update', $product['id']) }}" method="POST" class="w-75 mx-auto">
                @csrf
                @method('PUT')

                <!-- Campo Descrição -->
                <div class="form-group mb-3">
                    <label for="description" class="form-label">{{ __('Descrição') }}:</label>
                    <input type="text" id="description" name="description" class="form-control" value="{{ old('description', $product['description'] ?? '') }}" required>
                </div>

                <!-- Campo Preço -->
                <div class="form-group mb-3">
                    <label for="price" class="form-label">{{ __('Preço') }}:</label>
                    <input type="text" id="price" name="price" class="form-control" value="{{ old('price', $product['price'] ?? '') }}" required>
                </div>

                <!-- Botão de Atualização -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-edit"></i> {{ __('Atualizar Produto/Renda') }}
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
