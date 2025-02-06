@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{__('Condomínios')}}</h1>
            </div>
        </div>
    </div>
</div>

<!-- Card principal com mais margem e espaçamento -->
<div class="container mx-auto mt-12 flex justify-center">
    <div class="card shadow-lg w-full max-w-2xl mt-4 rounded-lg">
        <div class="card-header bg-blue-600 text-black text-center py-4">
            <h3 class="card-title font-bold text-xl">{{ __('Editar Condomínio') }}: {{ $condominio->nome }}</h3>
        </div>

        <div class="card-body">
            <form action="{{ route('condominios.update', $condominio->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Campo Nome -->
                <div class="form-group mb-4">
                    <label for="nome" class="control-label">{{ __('Nome') }}:</label>
                    <input type="text" name="nome" id="nome" value="{{ $condominio->nome }}" class="form-control" required>
                </div>

                <!-- Campo Endereço -->
                <div class="form-group mb-4">
                    <label for="endereco" class="control-label">{{ __('Endereço') }}:</label>
                    <input type="text" name="endereco" id="endereco" value="{{ $condominio->endereco }}" class="form-control" required>
                </div>

                <!-- Campo Cidade -->
                <div class="form-group mb-4">
                    <label for="cidade" class="control-label">{{ __('Cidade') }}:</label>
                    <input type="text" name="cidade" id="cidade" value="{{ $condominio->cidade }}" class="form-control" required>
                </div>

                <!-- Campo Código Postal -->
                <div class="form-group mb-4">
                    <label for="codigo_postal" class="control-label">{{ __('Código Postal') }}:</label>
                    <input type="text" name="codigo_postal" id="codigo_postal" value="{{ $condominio->codigo_postal }}" class="form-control" required>
                </div>

                <!-- Campo Manager -->
                <div class="form-group mb-4">
    <label for="manager_id" class="control-label">{{ __('Manager') }}</label>
    <select name="manager_id" id="manager_id" class="form-control" 
        @if(auth()->user()->role !== 'admin') disabled @endif>
        <option value="" disabled {{ !$condominio->manager_id ? 'selected' : '' }}>-- Select a Manager --</option>
        @foreach ($users->groupBy('condominio_id') as $condominioGroup => $groupUsers)
            @php
                $groupCondominio = \App\Models\Condominio::find($condominioGroup);
            @endphp
            <option value="" disabled style="font-weight: bold; padding-left: 10px;">
                {{ $groupCondominio->nome }}
            </option>
            @foreach ($groupUsers as $user)
                <option value="{{ $user->id }}" {{ $condominio->manager_id == $user->id ? 'selected' : '' }} style="padding-left: 20px;">
                    {{ $user->name }}
                </option>
            @endforeach
        @endforeach
    </select>

   <!-- Input oculto para utilizadores não administradores para evitar erros de validação -->
    @if(auth()->user()->role !== 'admin')
        <input type="hidden" name="manager_id" value="{{ $condominio->manager_id }}">
    @endif

    @if ($errors->has('manager_id'))
        <div class="text-red-500 text-sm mt-1">
            {{ $errors->first('manager_id') }}
        </div>
    @endif
</div>


                <!-- Botão de Enviar -->
                <div class="text-center">
                    <button type="submit" class="btn btn-warning">
                        {{ __('Atualizar Condomínio') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<<script>
    console.log("Editing Condomínio:", {
        id: {{ $condominio->id }},
        manager_id: {{ $condominio->manager_id ?? 'null' }}
    });
</script>

@endsection
