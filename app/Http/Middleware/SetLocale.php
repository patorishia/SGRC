<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\App;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Processa a solicitação recebida e define o idioma da aplicação com base na sessão.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Obtém o idioma definido na sessão, ou o idioma padrão da aplicação se não estiver definido
        $locale = session('locale', config('app.locale'));
        
        // Define o idioma da aplicação conforme o valor obtido
        App::setLocale($locale);
        
        // Permite que a solicitação prossiga
        return $next($request);
    }
}
