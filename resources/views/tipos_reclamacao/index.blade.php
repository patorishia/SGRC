@extends('layouts.app')

@section('header')
    <h1 class="m-0 text-dark">{{ __('Tipos de Reclamação') }}</h1>
@endsection

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <!-- Verificar se existem tipos de reclamação -->
            @if($tiposReclamacao->isEmpty())
                <div class="col-12 text-center">
                    <p class="text-muted">{{ __('Ainda não há tipos de reclamação.') }}</p>
                </div>
            @else
                <div class="col-12">
                    <!-- Cards com a listagem dos tipos de reclamação -->
                    <div class="row">
                        @php
                            // Gerar uma cor aleatória para os cards sem repetição
                            $colors = ['bg-primary', 'bg-success', 'bg-warning', 'bg-danger', 'bg-info', 'bg-secondary'];
                            $colorCount = count($colors);
                        @endphp
                        @foreach($tiposReclamacao as $index => $tipo)
                            @php
                                // Atribui uma cor diferente para cada card com opacidade
                                $color = $colors[$index % $colorCount]; // Garante que as cores não se repitam
                            @endphp
                            <div class="col-md-4 mb-4">
                                <div class="card shadow-lg border-0 rounded-lg" style="background-color: rgba({{ hex2rgb(hexColor($color)) }}, 0.8);">
                                    <div class="card-header text-white">
                                        <h5 class="card-title">{{ $tipo->tipo }}</h5>
                                    </div>
                                    <div class="card-body bg-light text-center">
                                        <a href="{{ route('tipos_reclamacao.show', $tipo->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> {{ __('Ver detalhes') }}
                                        </a>
                                    </div>
                                    <div class="card-footer text-center" style="background-color: transparent;">
                                        <span class="text-white">{{ __('Criado em: ') }} {{ $tipo->created_at->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Botão para adicionar tipo de reclamação -->
        <div class="row">
            <div class="col-12 text-center mt-4">
                <a href="{{ route('tipos_reclamacao.create') }}" class="btn btn-success">
                    <i class="fas fa-plus-circle"></i> {{ __('Adicionar Tipo de Reclamação') }}
                </a>
            </div>
        </div>
    </div>
@endsection

@php
// Função para converter cores hexadecimais para valores RGB
function hex2rgb($hex) {
    $hex = ltrim($hex, '#');
    $rgb = array_map('hexdec', str_split($hex, 2));
    return implode(',', $rgb);
}

// Função para obter o código hexadecimal das cores do Tailwind
function hexColor($class) {
    $colors = [
        'bg-primary' => '#007bff',
        'bg-success' => '#28a745',
        'bg-warning' => '#ffc107',
        'bg-danger'  => '#dc3545',
        'bg-info'    => '#17a2b8',
        'bg-secondary'=> '#6c757d',
    ];
    return $colors[$class] ?? '#ffffff'; // Retorna a cor hexadecimal para a classe
}
@endphp
