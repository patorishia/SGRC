@extends('layouts.app')

@section('header')
    <h1 class="m-0 text-dark">{{ __('Adicionar Tipo de Reclamação') }}</h1>
@endsection

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title">{{ __('Adicionar Tipo de Reclamação') }}</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('tipos_reclamacao.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="tipo" class="form-label">{{ __('Tipo') }}</label>
                                <input type="text" name="tipo" id="tipo" class="form-control" required />
                            </div>

                            <div class="mb-3">
                                <label for="descricao" class="form-label">{{ __('Descrição') }}</label>
                                <textarea name="descricao" id="descricao" class="form-control" rows="3"></textarea>
                            </div>

                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-plus"></i> {{ __('Adicionar') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
