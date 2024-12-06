@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Editar Reclamação') }}: {{ $reclamacao->descricao }}
    </h2>
@endsection

@section('content')
    <div class="container mx-auto mt-8">
        <div class="card shadow-lg">
            <div class="card-header bg-blue-600 text-white">
                <h3 class="card-title">{{ __('Editar Reclamação') }}</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('reclamacoes.update', $reclamacao->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="condomino_nif" class="control-label">{{ __('Condómino:') }}</label>
                        <select name="condomino_nif" id="condomino_nif" class="form-control" required>
                            @foreach($condominos as $condomino)
                                <option value="{{ $condomino->nif }}" {{ $reclamacao->condomino_nif == $condomino->nif ? 'selected' : '' }}>
                                    {{ $condomino->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="condominio_id" class="control-label">{{ __('Condomínio:') }}</label>
                        <select name="condominio_id" id="condominio_id" class="form-control" required>
                            @foreach($condominios as $condominio)
                                <option value="{{ $condominio->id }}" {{ $reclamacao->condominio_id == $condominio->id ? 'selected' : '' }}>
                                    {{ $condominio->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tipo_reclamacao" class="control-label">{{ __('Tipo de Reclamação:') }}</label>
                        <select name="tipo_reclamacao" id="tipo_reclamacao" class="form-control" required>
                            @foreach($tipos_reclamacao as $tipo)
                                <option value="{{ $tipo->id }}" {{ $reclamacao->tipo_reclamacao == $tipo->id ? 'selected' : '' }}>
                                    {{ $tipo->tipo }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="descricao" class="control-label">{{ __('Descrição:') }}</label>
                        <textarea name="descricao" id="descricao" class="form-control" required>{{ $reclamacao->descricao }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="estado" class="control-label">{{ __('Estado:') }}</label>
                        <input type="text" name="estado" id="estado" value="{{ $reclamacao->estado }}" class="form-control" required>
                    </div>

                    @if($reclamacao->anexos)
                        <div class="form-group">
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

                    <div class="form-group">
                        <label for="anexos" class="control-label">{{ __('Adicionar ou atualizar anexos:') }}</label>
                        <input type="file" name="anexos[]" id="anexos" class="form-control" multiple>
                    </div>

                    <button type="submit" class="btn btn-warning">
                        {{ __('Atualizar') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

