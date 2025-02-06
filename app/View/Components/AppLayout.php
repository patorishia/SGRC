<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    /**
     * Retorna a vista que representa este componente de layout.
     *
     * @return View
     */
    public function render(): View
    {
        return view('layouts.app'); // Usa a vista 'layouts.app' como estrutura base da aplicação
    }
}
