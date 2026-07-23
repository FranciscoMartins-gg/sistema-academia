<?php

use App\Controllers\AcessoController;
use App\Controllers\ClienteController;
use App\Controllers\DashBoardController;
use App\Controllers\LoginController;
use App\Controllers\PagamentoController;
use App\Controllers\PlanoController;

$rota = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? 'home';

$dashboardController = new DashBoardController();
$clienteController = new ClienteController();
$loginController = new LoginController();
$acessoController = new AcessoController();
$pagamentoController = new PagamentoController();
$planoController = new PlanoController();

switch ($rota) {

    case '/':
        $dashboardController->index();
        break;

    case '/clientes':
        $clienteController->index();
        break;
    
    case '/login':
        $loginController->index();
        break;

    case '/acesso':
        $acessoController->index();
        break;
    
    case '/pagamento':
        $pagamentoController->index();
        break;

    case '/plano':
        $planoController->index();
        break;
    
    default:
        echo "404 - Página não encontrada";
        break;
}