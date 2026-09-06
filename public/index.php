<?php
session_start();
date_default_timezone_set('America/Bahia');
require_once __DIR__ . '/../vendor/autoload.php';


use Config\Database;
use Config\Migrations;

$pdo = Database::getConnection();
//resetar banco de dados
// Migrations::reset($pdo);
//carrega as migrations
Migrations::load($pdo);


require_once __DIR__ . '/../routes/web.php';
