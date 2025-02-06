@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center align-items-center" style="height: 100vh; background-color: #f8f9fa;">
        <div class="card" style="width: 30rem; background-color: #fff; border: 1px solid #ddd;">
            <div class="card-body text-center text-dark">
                <h4 class="card-title mb-4 text-center">{{ __('Atenção!') }}</h4>
                <p class="card-text">{{ __('Esta página não existe ou você não está autorizado a acessar.') }}</p>
                <hr>
                <p class="card-text mb-0">{{ __('Se você acha que isso é um erro, entre em contato com o administrador do sistema.') }}</p>
            </div>
        </div>
    </div>
@endsection
