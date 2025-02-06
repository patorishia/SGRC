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
    <div class="container mx-auto mt-12 flex justify-center">
        <div class="card shadow-lg w-full max-w-2xl mt-4 rounded-lg">
            <div class="card-header bg-blue-600 text-black text-center py-4">
                <h3 class="card-title font-bold text-xl">{{ __('Pagamento para a Reclamação') }}: {{ $reclamacao->descricao }}</h3>
            </div>

            <div class="card-body">
                <p>{{ __('Estado atual') }}: <strong>{{ $reclamacao->estado->nome }}</strong></p>

                <!-- Examplo de formulário de pagamento -->
                
                    @csrf
                    <div class="text-center">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check-circle"></i> {{ __('Finalizar Pagamento') }}
                        </button>
                    </div>
                
            </div>
        </div>
    </div>
@endsection
