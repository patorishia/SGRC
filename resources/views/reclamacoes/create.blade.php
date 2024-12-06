@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Criar Reclamação') }}
    </h2>
@endsection

@section('content')
    <!-- Card principal com margem adequada -->
    <div class="container mx-auto mt-8">
        <div class="card shadow-lg">
            <div class="card-header bg-blue-600 text-white">
                <h3 class="card-title">{{ __('Criar Reclamação') }}</h3>
            </div>

            <div class="card-body">
                <form action="{{ route('reclamacoes.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="condominio_id" class="control-label">{{ __('Condomínio:') }}</label>
                        <select name="condominio_id" id="condominio_id" class="form-control" required>
                            <option value="" disabled selected>{{ __('Selecione um Condomínio') }}</option>
                            @foreach($condominios as $condominio)
                                <option value="{{ $condominio->id }}">{{ $condominio->nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="condomino_nif" class="control-label">{{ __('Condómino:') }}</label>
                        <select name="condomino_nif" id="condomino_nif" class="form-control" required>
                            <option value="" disabled selected>{{ __('Selecione um Condómino') }}</option>
                            @foreach($condominos as $condomino)
                                <option value="{{ $condomino->nif }}">{{ $condomino->nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tipo_reclamacao" class="control-label">{{ __('Tipo de Reclamação:') }}</label>
                        <select name="tipo_reclamacao" id="tipo_reclamacao" class="form-control" required>
                            <option value="" disabled selected>{{ __('Selecione o Tipo de Reclamação') }}</option>
                            @foreach($tiposReclamacao as $tipo)
                                <option value="{{ $tipo->id }}">{{ $tipo->tipo }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="descricao" class="control-label">{{ __('Descrição:') }}</label>
                        <textarea name="descricao" id="descricao" class="form-control" rows="4" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="estado" class="control-label">{{ __('Estado:') }}</label>
                        <select name="estado" id="estado" class="form-control" required>
                            @foreach($estados as $estado)
                                <option value="{{ $estado->id }}">{{ $estado->nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="anexos" class="control-label">{{ __('Adicionar ou atualizar anexos:') }}</label>
                        <input type="file" name="anexos[]" id="anexos" class="form-control" multiple>
                    </div>

                    <!-- Campos de nome para os anexos -->
                    <div id="anexo_nome_fields"></div>

                    <button type="submit" class="btn btn-success">
                        {{ __('Criar Reclamação') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('anexos').addEventListener('change', function() {
                var container = document.getElementById('anexo_nome_fields');
                container.innerHTML = ''; // Limpa os campos de nome existentes

                // Cria campos de nome para cada arquivo selecionado
                for (let i = 0; i < this.files.length; i++) {
                    var inputGroup = document.createElement('div');
                    inputGroup.classList.add('form-group');

                    var label = document.createElement('label');
                    label.setAttribute('for', 'anexo_nome_' + i);
                    label.classList.add('control-label');
                    label.textContent = '{{ __("Nome do anexo ") }}' + (i + 1) + ':'; 

                    var input = document.createElement('input');
                    input.setAttribute('type', 'text');
                    input.setAttribute('name', 'anexo_nome[]');
                    input.setAttribute('id', 'anexo_nome_' + i);
                    input.classList.add('form-control');
                    input.setAttribute('placeholder', '{{ __("Nome do anexo ") }}' + (i + 1));

                    inputGroup.appendChild(label);
                    inputGroup.appendChild(input);
                    container.appendChild(inputGroup);
                }
            });
        </script>
    @endpush
@endsection
