<?php

$rota = $_GET['rota'] ?? 'home';

switch ($rota) {

    case 'clientes':
        require_once '../app/Views/clientes/index.php';
        break;

    default:
        echo "404 - Página não encontrada";
        break;
}