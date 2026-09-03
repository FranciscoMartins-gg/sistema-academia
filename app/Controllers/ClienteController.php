<?php

namespace App\Controllers;

use App\Models\ClienteModel;

class ClienteController
{
    public function index()
    {
        $clientes = new ClienteModel();

        $clientes = $clientes->findAll();
        require_once __DIR__ . '/../Views/clientes/index.php';
    }
}