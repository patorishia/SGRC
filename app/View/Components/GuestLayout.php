<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class GuestLayout extends Component
{
    /**
     * Retorna a vista que representa o layout para utilizadores não autenticados.
     *
     * @return View
     */
    public function render(): View
    {
        return view('layouts.guest'); // Usa a vista 'layouts.guest' como estrutura base para visitantes
    }
}

