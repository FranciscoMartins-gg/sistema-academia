<?php

namespace App\Models;

use Config\Database;
use DateTime;
use PDO;
use PDOException;
use App\Models\PagamentoModel;
use App\Models\PlanoModel;

class ClienteModel
{

    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }


    public function create(array $dados): bool
    {
        $this->pdo->beginTransaction();

        try {

            $sql = "INSERT INTO 
                    clientes (id_plano, nome_cliente, email, telefone, status) 
                    VALUES
                    (:id_plano, :nome_cliente, :email, :telefone, :status)
            ";

            $stmt = $this->pdo->prepare($sql);

            $result = $stmt->execute([
                ":id_plano" => $dados["id_plano"],
                ":nome_cliente" => $dados["nome_cliente"],
                ":email" => $dados["email"],
                ":telefone" => $dados["telefone"],
                ":status" => $dados["status"]
            ]);

            if (!$result) {
                throw new PDOException("Erro ao criar cliente");
            }

            $id_cliente = $this->pdo->lastInsertId();

            $planoModel = new PlanoModel();
            $plano = $planoModel->findId($dados["id_plano"]);

            $pagamentoModel = new PagamentoModel();

            for ($i = 0; $i < $plano["duracao_meses"]; $i++) {

                $valor = round(
                    $plano["valor"] / $plano["duracao_meses"],
                    2
                );

                $data_inicio = new DateTime();
                $data_inicio->modify("+$i month");

                $data_vencimento = clone $data_inicio;
                $data_vencimento->modify("+1 month");

                $resultPagamento = $pagamentoModel->createPagamento([
                    "id_cliente" => $id_cliente,
                    "valor" => $valor,
                    "data_inicio" => $data_inicio->format("Y-m-d"),
                    "data_vencimento" => $data_vencimento->format("Y-m-d")
                ]);

                if (!$resultPagamento) {
                    throw new PDOException("Erro ao cria pagamento");
                }
            }
            $this->pdo->commit();
            return $result;
        } catch (PDOException $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }

            throw $e;
        }


        // $this->pdo->beginTransaction();
        // $sql = "INSERT INTO 
        //         clientes (id_plano, nome_cliente, email, telefone, status) 
        //         VALUES
        //         (:id_plano, :nome_cliente, :email, :telefone, :status)
        // ";

        // $stmt = $this->pdo->prepare($sql);

        // $result = $stmt->execute([
        //     ":id_plano"=> $dados["id_plano"], 
        //     ":nome_cliente"=> $dados["nome_cliente"], 
        //     ":email"=> $dados["email"], 
        //     ":telefone"=> $dados["telefone"],
        //     ":status"=> $dados["status"]
        //     ]);

        // if(!$result)return $result;

        // if($dados["status"] == "ATIVO"){
        //     $id_cliente = $this->pdo->lastInsertId();
        //     $planoModel = new PlanoModel();
        //     $plano = $planoModel->findId($dados["id_plano"]);
        //     for ($i=0; $i < $plano["duracao_meses"]; $i++) { 
        //         $valor = round($plano["valor"] / $plano["duracao_meses"], 2);
        //         $pagamentoModel = new PagamentosModel();
        //         $data_inicio = date('Y-m-d');
        //         $data_vencimento = new DateTime($data_inicio);
        //         $data_vencimento->modify("+" . ($i + 1) . "month");
        //         $data_vencimento = $data_vencimento->format("Y-m-d");
        //         $resultPagamentos = $pagamentoModel->createPagamento(
        //             ["id_cliente"=>$id_cliente, "valor"=>$valor, "data_inicial"=>$data_inicio, "data_vencimento"=>$data_vencimento]
        //         );
        //         if(!$resultPagamentos){
        //            return $this->pdo->rollBack();
        //         }
        //     }
        //     return $this->pdo->commit();
        // }

        // return true;   

    }

    public function update(array $cliente): bool
    {
        $sql = "UPDATE clientes SET nome_cliente = :nome_cliente, email = :email, telefone = :telefone, id_plano = :id_plano, status = :status
        WHERE id_cliente = :id_cliente";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'nome_cliente' => $cliente["nome_cliente"],
            'email' => $cliente["email"],
            'telefone' => $cliente["telefone"],
            'id_plano' => $cliente["id_plano"],
            'status' => $cliente["status"],
            'id_cliente' => $cliente["id_cliente"]
        ]);
    }

    public function findAll(string $busca = ''): array
    {
        $sql = "SELECT c.id_cliente, c.nome_cliente, c.email, c.telefone, c.status, p.nome_plano
        FROM clientes c
        LEFT JOIN planos p
        ON c.id_plano = p.id_plano";

        if ($busca !== '') {
            $sql .= " WHERE c.nome_cliente LIKE :busca";
        }

        $stmt = $this->pdo->prepare($sql);

        if ($busca !== '') {
            $stmt->execute([
                ':busca' => '%' . $busca . '%'
            ]);
        } else {
            $stmt->execute();
        }

        return $stmt->fetchAll();
    }

    public function findId(int $id_cliente): array
    {
        $sql = "SELECT * FROM clientes WHERE id_cliente = :id_cliente";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([":id_cliente" => $id_cliente]);
        return $stmt->fetch();
    }

    public function countBudget(): float
    {
        $sql = "SELECT COALESCE(SUM(p.valor), 0) AS total
        FROM clientes c
        INNER JOIN planos p ON c.id_plano = p.id_plano
        WHERE c.status = 'ATIVO'";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return (float) $stmt->fetch()['total'];
    }

    public function count(): int
    {
        $sql = "SELECT COUNT(*) AS total FROM clientes";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return (int) $stmt->fetch()["total"];
    }

    public function delete(int $id_cliente):bool{
        $sql = "DELETE FROM clientes WHERE id_cliente = :id_cliente";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([":id_cliente"=>$id_cliente]);
    }

    public function countActive(): int
    {
        $sql = "SELECT COUNT(*) AS total
        FROM clientes 
        WHERE status = 'ATIVO'
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return (int) $stmt->fetch()["total"];
    }
}
