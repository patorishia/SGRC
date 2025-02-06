@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ __('Reclamações') }}</h1>
            </div>
        </div>
    </div>
</div>

<!-- Card principal com mais margem e espaçamento -->
<div class="container mx-auto mt-12 flex justify-center">
    <div class="card shadow-lg w-full max-w-2xl mt-4 rounded-lg">
        <div class="card-header bg-blue-600 text-black text-center py-4">
            <h3 class="card-title font-bold text-xl">{{ __('Editar Reclamação') }}: {{ $reclamacao->descricao }}</h3>
        </div>

        <div class="card-body">
            <form action="{{ route('reclamacoes.update', $reclamacao->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Condomínio -->
                <div class="form-group mb-4">
                    <label for="condominio_id" class="control-label">{{ __('Condomínio:') }}</label>
                    <input type="text" id="condominio_id" class="form-control" value="{{ $reclamacao->condominio->nome }}" readonly>
                    <input type="hidden" name="condominio_id" value="{{ $reclamacao->condominio_id }}">
                </div>

                <!-- Condómino -->
                <div class="form-group mb-4">
                    <label for="user_id" class="control-label">{{ __('Condómino:') }}</label>
                    <input type="text" id="user_id" class="form-control" value="{{ $reclamacao->user->name }}" readonly>
                    <input type="hidden" name="user_id" value="{{ $reclamacao->user_id }}">
                </div>

                <!-- Tipo de Reclamação -->
                <div class="form-group mb-4">
                    <label for="tipo_reclamacao" class="control-label">{{ __('Tipo de Reclamação:') }}</label>
                    <select name="tipo_reclamacao" id="tipo_reclamacao" class="form-control" required>
                        @foreach($tipos_reclamacao as $tipo)
                            <option value="{{ $tipo->id }}" {{ $reclamacao->tipo_reclamacao == $tipo->id ? 'selected' : '' }}>
                                {{ $tipo->tipo }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Descrição -->
                <div class="form-group mb-4">
                    <label for="descricao" class="control-label">{{ __('Descrição:') }}</label>
                    <textarea name="descricao" id="descricao" class="form-control" required>{{ $reclamacao->descricao }}</textarea>
                </div>

                <!-- Estado -->
                <div class="form-group mb-4">
                    <label for="estado_id">{{ __('Estado:') }}</label>
                    @if(auth()->user()->role === 'admin' || auth()->user()->id === $reclamacao->condominio->manager_id)

                        <select name="estado_id" id="estado_id" class="form-control">
                            @foreach($estados as $estado)
                                <option value="{{ $estado->id }}" {{ $reclamacao->estado_id == $estado->id ? 'selected' : '' }}>
                                    {{ $estado->nome }}
                                </option>
                            @endforeach
                        </select>
                    @elseif(Auth::user()->id == $reclamacao->user_id)
                        <select name="estado_id" id="estado_id" class="form-control">
                            <option value="{{ $reclamacao->estado_id }}" selected>
                                {{ $reclamacao->estado->nome }}
                            </option>
                        </select>
                    @else
                        <p>{{ $reclamacao->estado->nome }}</p>
                    @endif
                </div>

                <!-- Anexos Atuais -->
                @if($reclamacao->anexos)
                    <div class="form-group mb-4">
                        <label class="control-label">{{ __('Anexos Atuais:') }}</label>
                        @foreach(json_decode($reclamacao->anexos) as $anexo)
                            @php
                                $filePath = public_path('storage/' . $anexo);
                                $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
                            @endphp

                            <div class="mt-2">
                                @if(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                                    <img src="{{ asset('storage/' . $anexo) }}" alt="Anexo" class="w-32 h-32 object-cover mb-2">
                                @else
                                    <a href="{{ asset('storage/' . $anexo) }}" class="btn btn-primary btn-sm" download>
                                        <i class="fas fa-file"></i> {{ pathinfo($anexo, PATHINFO_BASENAME) }}
                                    </a>
                                @endif

                                <div class="mt-2">
                                    <label for="remove_anexo_{{ $loop->index }}" class="inline-flex items-center">
                                        <input type="checkbox" name="remove_anexos[]" value="{{ $anexo }}" id="remove_anexo_{{ $loop->index }}" class="mr-2">
                                        {{ __('Remover este anexo') }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Adicionar ou atualizar anexos -->
                <div class="form-group mb-4">
                    <label for="anexos" class="control-label">{{ __('Adicionar ou atualizar anexos:') }}</label>
                    <input type="file" name="anexos[]" id="anexos" class="form-control" multiple>
                </div>

                <!-- Botão de Enviar -->
                <div class="text-center">
                    <button type="submit" class="btn btn-warning">
                        {{ __('Atualizar Reclamação') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
