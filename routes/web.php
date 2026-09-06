<?php

use App\Controllers\AcessoController;
use App\Controllers\ClienteController;
use App\Controllers\DashboardController;
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

    //Clientes
    case '/clientes':
        $clienteController->index();
        break;

    case '/clientes/cadastrar':
        $clienteController->cadastrar();
        break;

    case '/clientes/editar':
        $clienteController->editar();
        break;

    case '/clientes/deletar':
        $clienteController->deletar();
    break;



    case '/login':
        $loginController->index();
        break;

    case '/acessos':
        $acessoController->index();
        break;

    case '/acessos/entrada':
        $acessoController->entrada();
        break;

    case '/acessos/saida':
        $acessoController->saida();
        break;


    case '/pagamentos':
        $pagamentoController->index();
        break;

    case '/pagamentos/pagar':
        $pagamentoController->pagar();
        break;

    case '/planos':
        $planoController->index();
        break;

    case '/planos/cadastrar':
        $planoController->create();
        break;

    case '/planos/editar':
        $planoController->editar();
        break;
        

    default:
        echo "404 - Página não encontrada";
        break;
}
