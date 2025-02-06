@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{__('Reclamações')}}</h1>
            </div>
        </div>
    </div>
</div>

<!-- Card principal com mais margem e espaçamento -->
<div class="container mx-auto mt-12 flex justify-center">
    <div class="card shadow-lg w-full max-w-2xl mt-4 rounded-lg">
        <div class="card-header bg-blue-600 text-black text-center py-4">
            <h3 class="card-title font-bold text-xl ">{{ __('Criar Reclamação') }}</h3>
        </div>

        <div class="card-body">
            <form action="{{ route('reclamacoes.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Condomínio -->
                <div class="form-group mb-4">
                    <label for="condominio_id" class="control-label">{{ __('Condomínio:') }}</label>
                    <input type="text" id="condominio_id" class="form-control" value="{{ $currentCondominio->nome }}" readonly>
                    <input type="hidden" name="condominio_id" value="{{ $currentCondominio->id }}">
                </div>

                <!-- Condómino -->
                <div class="form-group mb-4">
                    <label for="user_id" class="control-label">{{ __('Condómino:') }}</label>
                    <input type="text" id="user_id" class="form-control" value="{{ $currentUser->name }}" readonly>
                    <input type="hidden" name="user_id" value="{{ $currentUser->id }}">
                </div>

                <!-- Tipo de Reclamação -->
                <div class="form-group mb-4">
                    <label for="tipo_reclamacao" class="control-label">{{ __('Tipo de Reclamação:') }}</label>
                    <select name="tipo_reclamacao" id="tipo_reclamacao" class="form-control" required>
                        <option value="" disabled selected>{{ __('Selecione o Tipo de Reclamação') }}</option>
                        @foreach($tiposReclamacao as $tipo)
                            <option value="{{ $tipo->id }}">{{ $tipo->tipo }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Descrição -->
                <div class="form-group mb-4">
                    <label for="descricao" class="control-label">{{ __('Descrição:') }}</label>
                    <textarea name="descricao" id="descricao" class="form-control" rows="4" required></textarea>
                </div>

                <!-- Estado -->
                <div class="form-group mb-4">
                    <label for="estado_id" class="control-label">{{ __('Estado:') }}</label>
                    <input type="text" id="estado_id" class="form-control" value="Pendente" readonly>
                </div>

                <!-- Anexos -->
                <div class="form-group mb-4">
                    <label for="anexos" class="control-label">{{ __('Adicionar ou atualizar anexos:') }}</label>
                    <input type="file" name="anexos[]" id="anexos" class="form-control" multiple>
                </div>

                <!-- Campos de nome para os anexos -->
                <div id="anexo_nome_fields"></div>

                <!-- Botão de Enviar -->
                <div class="text-center">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-plus-circle"></i> {{ __('Criar Reclamação') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.getElementById('anexos').addEventListener('change', function () {
            var container = document.getElementById('anexo_nome_fields');
            container.innerHTML = ''; // Limpa os campos de nome existentes

            for (let i = 0; i < this.files.length; i++) {
                var inputGroup = document.createElement('div');
                inputGroup.classList.add('form-group', 'mb-4');

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
