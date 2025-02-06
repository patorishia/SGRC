@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{__('Condóminos')}}</h1>
            </div>
        </div>
    </div>
</div>

<!-- Card principal com mais margem e espaçamento -->
<div class="container mx-auto mt-12 flex justify-center">
    <div class="card shadow-lg w-full max-w-2xl mt-4 rounded-lg">
        <div class="card-header bg-blue-600 text-black text-center py-4">
            <h3 class="card-title font-bold text-xl">{{ __('Editar Condómino') }}: {{ $user->name }}</h3>
        </div>

        <div class="card-body">
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Campo Nome -->
                <div class="form-group mb-4">
                    <label for="name" class="control-label">{{ __('Nome') }}:</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="form-control @error('name') is-invalid @enderror" required>
                    @error('name')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Campo Email -->
                <div class="form-group mb-4">
                    <label for="email" class="control-label">{{ __('Email') }}:</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="form-control @error('email') is-invalid @enderror" required>
                    @error('email')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Campo Telefone -->
                <div class="form-group mb-4">
                    <label for="telefone" class="control-label">{{ __('Telefone') }}:</label>
                    <input type="text" name="telefone" id="telefone" value="{{ old('telefone', $user->telefone) }}" class="form-control @error('telefone') is-invalid @enderror" required>
                    @error('telefone')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Campo Papel -->
                <div class="form-group mb-4">
                    <label for="role" class="control-label">{{ __('Papel') }}:</label>
                    <select name="role" id="role" class="form-control @error('role') is-invalid @enderror" required>
                        <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>{{ __('Utilizador') }}</option>
                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>{{ __('Admin') }}</option>
                    </select>
                    @error('role')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Campo Condomínio -->
                <div class="form-group mb-4">
                    <label for="condominio_id" class="control-label">{{ __('Condomínio') }}:</label>
                    <select name="condominio_id" id="condominio_id" class="form-control @error('condominio_id') is-invalid @enderror" required>
                        @foreach($condominios as $condominio)
                            <option value="{{ $condominio->id }}" {{ old('condominio_id', $user->condominio_id) == $condominio->id ? 'selected' : '' }}>
                                {{ $condominio->nome }}
                            </option>
                        @endforeach
                    </select>
                    @error('condominio_id')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Botão de Enviar -->
                <div class="text-center">
                    <button type="submit" class="btn btn-warning">
                        {{ __('Atualizar Condómino') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
