<?php


namespace App\Models;

use Config\Database;
use PDO;


class PlanoModel{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }


    public function create(array $dados):bool{
            $sql = "INSERT INTO
            planos (nome_plano, valor, duracao_meses)
            VALUES
            (:nome_plano, :valor, :duracao_meses)";

            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                ":nome_plano"=> $dados["nome_plano"], 
                ":valor"=> $dados["valor"], 
                ":duracao_meses"=> $dados["duracao_meses"]
                ]);
    }

    public function update(array $dados):bool{
        $sql = "UPDATE planos SET nome_plano = :nome_plano, valor = :valor, duracao_meses = :duracao_meses 
        WHERE id_plano = :id_plano";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([  
            ":nome_plano"=>$dados["nome_plano"],
            ":valor"=>$dados["valor"],
            ":duracao_meses"=>$dados["duracao_meses"],
            ":id_plano"=>$dados["id_plano"]
            ]);
    }
    
    public function findId(int $id_plano):array{
        $sql = "SELECT * FROM planos WHERE id_plano = :id_plano";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([":id_plano"=>$id_plano]);
        
        return $stmt->fetch();
    }

    public function findAll():array{
        $sql = "SELECT * FROM planos";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    public function findForSelect():array{
        $sql = "SELECT id_plano, nome_plano  FROM planos";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

}