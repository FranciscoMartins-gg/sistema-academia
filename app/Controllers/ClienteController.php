<?php

namespace App\Controllers;

class ClienteController
{
    public function index()
    {
        require_once __DIR__ . '/../Views/clientes/index.php';
    }
}