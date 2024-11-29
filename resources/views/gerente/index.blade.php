@extends('layouts.app')

@section('header')
    <h1 class="m-0 text-dark">{{ __('Condomínos') }}</h1>
@endsection

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <!-- Verificar se existem condomínios -->
            @if($condominos->isEmpty())
                <div class="col-12 text-center">
                    <p class="text-muted">{{ __('Ainda não há nenhum condomíno.') }}</p>
                </div>
            @else
                <div class="col-12">
                    <!-- Cards com a listagem dos condomínios -->
                    <div class="row">
                        @php
                            // Definir as cores aleatórias para os cards
                            $colors = ['#007bff', '#28a745', '#ffc107', '#dc3545', '#17a2b8', '#6c757d']; // Hex colors
                            $colorCount = count($colors);
                        @endphp
                        @foreach($condominos as $index => $condomino)
                            @php
                                // Atribuir cor aleatória
                                $color = $colors[$index % $colorCount]; // A cor será rotacionada
                            @endphp
                            <div class="col-md-4 mb-4">
                                <div class="card shadow-lg" style="background-color: rgba({{ hex2rgb($color) }}, 0.8);">
                                    <div class="card-header text-white">
                                        <h5 class="card-title">{{ $condomino->nome }}</h5>
                                    </div>
                                    <div class="card-body bg-light text-center text-dark">
                                        <p><strong>Email:</strong> {{ $condomino->email }}</p>
                                        <p><strong>Telefone:</strong> {{ $condomino->telefone }}</p>
                                        <a href="{{ route('gerente.show', $condomino->nif) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> {{ __('Ver detalhes') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Botão para adicionar condomíno -->
        <div class="row mt-4">
            <div class="col-12 text-center">
                <a href="{{ route('gerente.create') }}" class="btn btn-success">
                    <i class="fas fa-plus-circle"></i> {{ __('Adicionar Condomíno') }}
                </a>
            </div>
        </div>
    </div>
@endsection

@php
    // Função para converter hex em rgb
    function hex2rgb($hex) {
        $hex = str_replace("#", "", $hex);
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
        return "$r, $g, $b";
    }
@endphp
