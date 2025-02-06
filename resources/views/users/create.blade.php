@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Condóminos') }}</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Card principal com mais margem e espaçamento -->
    <div class="container mx-auto mt-12 flex justify-center">
        <div class="card shadow-lg w-full max-w-2xl mt-4 rounded-lg">
            <div class="card-header bg-blue-600 text-black text-center py-4">
                <h3 class="card-title font-bold text-xl ">{{ __('Adicionar Condóminos') }}</h3>
            </div>

            <div class="card-body">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf

                    <!-- Campo Nome -->
                    <div class="form-group mb-4">
                        <label for="name" class="control-label">{{ __('Nome') }}:</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>

                    <!-- Campo Email -->
                    <div class="form-group mb-4">
                        <label for="email" class="control-label">{{ __('Email') }}:</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>

                    <!-- Campo Telefone -->
                    <div class="form-group mb-4">
                        <label for="telefone" class="control-label">{{ __('Telefone') }}:</label>
                        <input type="text" name="telefone" id="telefone" class="form-control" required>
                    </div>

                    <!-- Campo Papel -->
                    <div class="form-group mb-4">
                        <label for="role" class="control-label">{{ __('Papel') }}:</label>
                        <select name="role" id="role" class="form-control" required {{ Auth::user()->role != 'admin' ? 'disabled' : '' }}>
                            <option value="user">{{ __('Utilizador') }}</option>
                            <option value="admin">{{ __('Admin') }}</option>
                        </select>
                    </div>

                    <!-- Campo NIF -->
                    <div class="form-group mb-4">
                        <label for="nif" class="control-label">{{ __('NIF') }}:</label>
                        <input type="text" name="nif" id="nif" class="form-control" required>
                    </div>

                    <!-- Campo Condomínio -->
                    <div class="form-group mb-4">
                        <label for="condominio_id" class="control-label">{{ __('Condomínio') }}:</label>
                        <select name="condominio_id" id="condominio_id" class="form-control" required>
                            @php
                                $condominios = Auth::user()->role == 'admin' 
                                    ? \App\Models\Condominio::all() 
                                    : \App\Models\Condominio::where('manager_id', Auth::id())->get();
                            @endphp
                            @foreach ($condominios as $condominio)
                                <option value="{{ $condominio->id }}">{{ $condominio->nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Botão de Enviar -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-plus-circle"></i> {{ __('Criar Condómino') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
