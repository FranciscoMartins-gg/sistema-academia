<?php

namespace App\Controllers;

class DashBoardController
{
    public function index()
    {
        require_once __DIR__ . '/../Views/dashBoard/index.php';
    }
}