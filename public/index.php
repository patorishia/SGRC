<?php

use Illuminate\Http\Request;

// Define o tempo de início do Laravel para medir a performance
define('LARAVEL_START', microtime(true));

// Verifica se a aplicação está em modo de manutenção, caso o ficheiro de manutenção exista
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance; // Carrega o ficheiro de manutenção, caso esteja em manutenção
}

// Regista o autoloader do Composer, responsável por carregar as dependências do projeto
require __DIR__.'/../vendor/autoload.php';

// Inicializa o Laravel e processa a requisição
(require_once __DIR__.'/../bootstrap/app.php')
    ->handleRequest(Request::capture()); // Captura a requisição HTTP e inicia o tratamento
