@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Adicionar Condomino') }}
    </h2>
@endsection

@section('content')
    <!-- Card principal com margem adequada -->
    <div class="container mx-auto mt-8">
        <div class="card shadow-lg">
            <div class="card-header bg-blue-600 text-white">
                <h3 class="card-title">Adicionar Condomino</h3>
            </div>

            <div class="card-body">
                <form action="{{ route('gerente.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="nome" class="control-label">Nome:</label>
                        <input type="text" name="nome" id="nome" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="email" class="control-label">Email:</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="telefone" class="control-label">Telefone:</label>
                        <input type="text" name="telefone" id="telefone" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="condominio_id" class="control-label">Condomínio:</label>
                        <select name="condominio_id" id="condominio_id" class="form-control" required>
                            @foreach($condominios as $condominio)
                                <option value="{{ $condominio->id }}">{{ $condominio->nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">
                        Criar Condomino
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
