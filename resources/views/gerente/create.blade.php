@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Adicionar Condomino') }}
    </h2>
@endsection

@section('content')
    <div class="p-6 text-gray-900 dark:text-gray-100">
        <form action="{{ route('gerente.store') }}" method="POST">
            @csrf
            <div>
                <label for="nome">Nome</label>
                <input type="text" name="nome" required>
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" name="email" required>
            </div>
            <div>
                <label for="telefone">Telefone</label>
                <input type="text" name="telefone" required>
            </div>
            <div>
                <label for="condominio_id">Condomínio</label>
                <select name="condominio_id" required>
                    @foreach($condominios as $condominio)
                        <option value="{{ $condominio->id }}">{{ $condominio->nome }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit">Criar Condomino</button>
        </form>
    </div>
@endsection
