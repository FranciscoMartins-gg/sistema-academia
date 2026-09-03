<?php


namespace Config;

use PDO;

class Migrations
{

    public static function reset(PDO $pdo): void
    {
        $pdo->exec("DROP TABLE IF EXISTS acessos");
        $pdo->exec("DROP TABLE IF EXISTS pagamentos");
        $pdo->exec("DROP TABLE IF EXISTS clientes");
        $pdo->exec("DROP TABLE IF EXISTS planos");
    }

    public static function load(PDO $pdo): void
    {
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS planos (
                id_plano INT AUTO_INCREMENT PRIMARY KEY,
                nome_plano VARCHAR(100) NOT NULL,
                valor DECIMAL(10,2) NOT NULL,
                duracao_meses INT NOT NULL
            );
        ");

        $pdo->exec("
            CREATE TABLE IF NOT EXISTS clientes (
                id_cliente INT AUTO_INCREMENT PRIMARY KEY,
                id_plano INT NOT NULL,
                nome_cliente VARCHAR(100) NOT NULL,
                email VARCHAR(100) NOT NULL UNIQUE,
                telefone VARCHAR(20) NOT NULL,
                status ENUM('ATIVO', 'INATIVO') NOT NULL DEFAULT 'ATIVO',

                CONSTRAINT fk_cliente_plano
                    FOREIGN KEY (id_plano)
                    REFERENCES planos(id_plano)
            );
        ");

        $pdo->exec(
            "
        CREATE TABLE IF NOT EXISTS pagamentos (
            id_pagamento INT AUTO_INCREMENT PRIMARY KEY,
            id_cliente INT NOT NULL,
            valor FLOAT NOT NULL,
            data_inicio DATE NOT NULL,
            data_vencimento DATE NOT NULL,
            status ENUM('Pago','Pendente','Atrasado') NOT NULL DEFAULT 'Pendente',

        CONSTRAINT fk_pagamento_cliente
            FOREIGN KEY (id_cliente)
            REFERENCES clientes(id_cliente)
            ON DELETE CASCADE
            );"
        );

        $pdo->exec(
            "
        CREATE TABLE IF NOT EXISTS acessos (
            id_acesso INT AUTO_INCREMENT PRIMARY KEY,
            id_cliente INT NOT NULL,
            data DATE NOT NULL,
            hora_entrada TIME NOT NULL,
            hora_saida TIME,

        CONSTRAINT fk_acesso_cliente
            FOREIGN KEY (id_cliente)
            REFERENCES clientes(id_cliente)
            ON DELETE CASCADE
            );"
        );
    }
}
