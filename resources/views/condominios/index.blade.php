@extends('layouts.app')

@section('header')
    <h1 class="m-0 text-dark">{{ __('Condomínios') }}</h1>
@endsection

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <!-- Verificar se existem condomínios -->
            @if($condominios->isEmpty())
                <div class="col-12 text-center">
                    <p class="text-muted">{{ __('Ainda não há nenhum condomínio.') }}</p>
                </div>
            @else
                <div class="col-12">
                    <!-- Cards com a listagem dos condomínios -->
                    <div class="row">
                        @php
                            // Definir as cores aleatórias para os cards
                            $colors = ['bg-primary', 'bg-success', 'bg-warning', 'bg-danger', 'bg-info', 'bg-secondary'];
                            $colorCount = count($colors);
                        @endphp
                        @foreach($condominios as $index => $condominio)
                            @php
                                // Atribuir cor aleatória com opacidade de 0.8
                                $color = $colors[$index % $colorCount]; // A cor será rotacionada
                            @endphp
                            <div class="col-md-4 mb-4">
                                <div class="card shadow-lg" style="background-color: rgba({{ hex2rgb(hexColor($color)) }}, 0.8);">
                                    <div class="card-header text-white">
                                        <h5 class="card-title">{{ $condominio->nome }}</h5>
                                    </div>
                                    <div class="card-body bg-light text-center text-dark">
                                        <p><strong>Endereço:</strong> {{ $condominio->endereco }}</p>
                                        <p><strong>Cidade:</strong> {{ $condominio->cidade }}</p>
                                        <a href="{{ route('condominios.show', $condominio->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> {{ __('Ver detalhes') }}
                                        </a>
                                    </div>
                                    <div class="card-footer text-center" style="background-color: transparent;">
                                        <span class="text-white">{{ __('Criado em: ') }} {{ $condominio->created_at->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Botão para adicionar condomínio -->
        <div class="row mt-4">
            <div class="col-12 text-center">
                <a href="{{ route('condominios.create') }}" class="btn btn-success">
                    <i class="fas fa-plus-circle"></i> {{ __('Adicionar Condomínio') }}
                </a>
            </div>
        </div>
    </div>
@endsection

@php
// Função para converter hex em rgb
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
