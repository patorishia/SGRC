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

    <div class="container mx-auto mt-12 flex justify-center">
        <div class="card shadow-lg w-full max-w-2xl mt-4 rounded-lg">
            <div class="card-header bg-blue-600 text-black text-center py-4">
                <h3 class="card-title font-bold text-xl">{{ __('Processar Reclamação') }}: {{ $reclamacao->descricao }}</h3>
            </div>

            <div class="card-body">
                <form action="{{ route('reclamacoes.updateProcess', $reclamacao->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

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
                        <input type="text" class="form-control" value="{{ $reclamacao->tipoReclamacao->tipo }}" readonly>
                    </div>

                    <!-- Descrição -->
                    <div class="form-group mb-4">
                        <label class="control-label">{{ __('Descrição:') }}</label>
                        <div class="form-control-plaintext">
                            {{ $reclamacao->descricao }}
                        </div>
                    </div>

                    <!-- Estado -->
                    <div class="form-group mb-4">
                        <label for="estado_id" class="control-label">{{ __('Estado:') }}</label>
                        <select name="estado_id" id="estado_id" class="form-control">
                            @foreach($estados as $estado)
                                <option value="{{ $estado->id }}" {{ $estado->id == $reclamacao->estado_id ? 'selected' : '' }}>
                                    {{ $estado->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Processo -->
                    <div class="form-group mb-4">
                        <label for="processo" class="control-label">{{ __('Processo:') }}</label>
                        <textarea name="processo" id="processo" class="form-control">{{ $reclamacao->processo }}</textarea>
                    </div>

                    <!-- Anexos -->
                    <div class="form-group mb-4">
                        <label for="anexos" class="control-label">{{ __('Adicionar ou atualizar anexos:') }}</label>
                        <input type="file" name="anexos[]" multiple class="form-control">
                    </div>

                    <!-- Anexos Atuais -->
                    @if($reclamacao->anexos)
                        <div class="form-group mb-4">
                            <label class="control-label">{{ __('Anexos Atuais:') }}</label>
                            @foreach(json_decode($reclamacao->anexos) as $anexo)
                                <div class="mt-2">
                                    <a href="{{ asset('storage/' . $anexo) }}" class="btn btn-primary btn-sm" download>
                                        <i class="fas fa-file"></i> {{ basename($anexo) }}
                                    </a>
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

                    <div class="text-center">
                        <button type="submit" class="btn btn-warning">
                            {{ __('Processar Reclamação') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
