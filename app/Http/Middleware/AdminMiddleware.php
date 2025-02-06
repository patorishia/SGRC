<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * Processa a solicitação recebida e verifica se o utilizador tem permissão de administrador.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Verifica se o utilizador está autenticado e se tem o papel de 'admin'
        if (auth()->check() && auth()->user()->role === 'admin') {
            // Se for administrador, permite que a solicitação prossiga
            return $next($request);
        }

        // Se o utilizador não for administrador, redireciona para a página inicial
        return redirect()->route('home');
    }
}
