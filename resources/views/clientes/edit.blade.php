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

<div class="container mx-auto mt-12 flex justify-center">
    <div class="card shadow-lg w-full max-w-2xl mt-4 rounded-lg">
        <div class="card-header bg-blue-600 text-black text-center py-4">
            <h3 class="card-title font-bold text-xl">{{ __('Editar Cliente') }}</h3>
        </div>

        <div class="card-body">
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('clientes.update', $client['id']) }}" method="POST" class="w-75 mx-auto">
                @csrf
                @method('PUT')

                <!-- Campo Nome -->
                <div class="form-group mb-3">
                    <label for="name" class="form-label">{{ __('Nome') }}:</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $client['name']) }}" required>
                </div>

                <!-- Campo Endereço -->
                <div class="form-group mb-3">
                    <label for="address" class="form-label">{{ __('Endereço') }}:</label>
                    <input type="text" id="address" name="address" class="form-control" value="{{ old('address', $client['address']) }}" required>
                </div>

                <!-- Campo Código Postal -->
                <div class="form-group mb-3">
                    <label for="postalCode" class="form-label">{{ __('Código Postal') }}:</label>
                    <input type="text" id="postalCode" name="postalCode" class="form-control" value="{{ old('postalCode', $client['postalCode']) }}" required>
                </div>

                <!-- Botão de Atualização -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-edit"></i> {{ __('Atualizar Cliente') }}
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
