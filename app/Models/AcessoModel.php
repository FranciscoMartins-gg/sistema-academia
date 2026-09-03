<?php

namespace App\Models;

use Config\Database;
use PDO;

class AcessoModel
{

    private PDO $pdo;


    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }


    public function findAll(): array
    {
        $sql = "SELECT * FROM acessos";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function create(int $id_cliente): bool
    {
        if($this->verificarEntrada($id_cliente)) return false;
        $date = date('Y-m-d');
        $hora_entrada = date('H:i:s');

        $sql = "INSERT INTO acessos 
        (id_cliente, data, hora_entrada) 
        VALUES 
        (:id_cliente, :data, :hora_entrada)";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ":id_cliente" => $id_cliente,
            ":data" => $date,
            ":hora_entrada" => $hora_entrada
        ]);
    }

    public function verificarEntrada(int $id_cliente):bool{
        $sql = "SELECT COUNT(*) AS total FROM acessos 
        WHERE id_cliente = :id_cliente 
        AND data = CURDATE()";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([":id_cliente"=>$id_cliente]);
        return (int) $stmt->fetch()["total"] > 0;
    }

    public function update(int $id_acesso): bool
    {
        $hora_saida = date('H:i:s');

        $sql = "UPDATE acessos SET hora_saida = :hora_saida WHERE id_acesso = :id_acesso";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([":id_acesso" => $id_acesso, ":hora_saida" => $hora_saida]);
    }


    public function countToday(): int
    {
        $sql = "SELECT COUNT(*) AS total
        FROM acessos
        WHERE data = CURDATE()
    ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return (int) $stmt->fetch()['total'];
    }

    public function last():array{
        $sql = "SELECT a.id_cliente, c.nome_cliente, a.hora_entrada 
        FROM acessos a
        INNER JOIN clientes c
        ON a.id_cliente = c.id_cliente
        ORDER BY a.data, a.hora_entrada DESC 
        LIMIT 5
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();        
        return $stmt->fetchAll();
    }
}
