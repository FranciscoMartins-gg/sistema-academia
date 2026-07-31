<?php


namespace Config;

use PDO;

 class Migrations{

    public static function load(PDO $pdo):void{
        //criando a tabela de cliente caso não exista
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS clientes(
                id_cliente INT AUTO_INCREMENT PRIMARY KEY,
                nome_cliente VARCHAR(100) NOT NULL,
                email VARCHAR(100) NOT NULL UNIQUE,
                telefone VARCHAR(100) NOT NULL UNIQUE
            );
        ");

        $pdo->exec("
            CREATE TABLE IF NOT EXISTS pagamento(
                id_cliente INT AUTO_INCREMENT PRIMARY KEY,
                nome_cliente VARCHAR(100) NOT NULL,
                email VARCHAR(100) NOT NULL UNIQUE,
                telefone VARCHAR(100) NOT NULL UNIQUE
            );
        ");

    }
 }
