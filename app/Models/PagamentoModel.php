<?php


namespace App\Models;

use Config\Database;
use DateTime;
use Exception;
use PDO;
use PDOException;

class PagamentoModel
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function createPagamento(array $dados): bool
    {
        $sql = "INSERT INTO 
        pagamentos (id_cliente, valor, data_inicio, data_vencimento) 
        VALUES 
        (:id_cliente, :valor, :data_inicio, :data_vencimento)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ":id_cliente" => $dados["id_cliente"],
            ":valor" => $dados["valor"],
            ":data_inicio" => $dados["data_inicio"],
            ":data_vencimento" => $dados["data_vencimento"]
        ]);
    }

    public function findId(int $id_pagamento): array
    {
        $sql = "SELECT * FROM pagamentos 
        WHERE id_pagamento = :id_pagamento";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([":id_pagamento" => $id_pagamento]);
        return $stmt->fetch();
    }

    public function findIdCliente(int $id_cliente): array
    {
        $sql = "SELECT * FROM pagamentos 
        WHERE id_cliente = :id_cliente";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([":id_cliente" => $id_cliente]);
        return $stmt->fetchAll();
    }

    public function atrasados():array{
        $sql = "SELECT c.id_cliente, c.nome_cliente, COUNT(p.id_pagamento) AS quantidade_atrasada , p.valor 
        FROM pagamentos p
        INNER JOIN clientes c
        ON p.id_cliente = c.id_cliente
        WHERE p.status = 'Atrasado'
        GROUP BY c.id_cliente, c.nome_cliente, p.valor
        ORDER BY p.valor DESC
        LIMIT 5
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function verificarPagamentosAtrasados(): bool
    {
        $sql = "UPDATE pagamentos
        SET status = 'Atrasado'
        WHERE data_vencimento < CURDATE()
        AND status = 'Pendente'
    ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute();
    }

    public function verificarPagamentoAnterior(int $id_cliente, string $data_inicio): bool
    {
        $sql = "SELECT COUNT(*) AS total 
        FROM pagamentos 
        WHERE id_cliente = :id_cliente 
        AND data_inicio < :data_inicio 
        AND status != 'PAGO'
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ":id_cliente" => $id_cliente,
            ":data_inicio" => $data_inicio
        ]);

        return (int) $stmt->fetch()["total"] > 0;
    }

    //função para verificar se já tem um proximo pagamento para o proximo mês
    public function verificarProxPagamento(int $id_cliente, string $data_inicio): bool
    {
        $sql = "SELECT COUNT(*) AS total
        FROM pagamentos
        WHERE id_cliente = :id_cliente
        AND data_inicio = :data_inicio
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':id_cliente' => $id_cliente,
            ':data_inicio' => $data_inicio
        ]);

        return (int) $stmt->fetch()['total'] > 0;
    }

    public function findAll(): array
    {
        $sql = "SELECT * FROM pagamentos";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    //função onde muda o status de pagamento para pago e cria um proximo pagamento
    public function pagar(int $id_pagamento): bool
    {
        $this->pdo->beginTransaction();

        try {
            $sql = "UPDATE pagamentos 
            SET status = 'PAGO' 
            WHERE id_pagamento = :id_pagamento";

            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([":id_pagamento" => $id_pagamento]);

            $antigo_pagamento = $this->findId($id_pagamento);
            $id_cliente = $antigo_pagamento["id_cliente"];
            $proximoPagamento =  $this->verificarProxPagamento($id_cliente, $antigo_pagamento["data_vencimento"]);
            $clienteModel = new ClienteModel();
            $planoModel = new PlanoModel();

            if (!$proximoPagamento) {
                $atrasado = $this->verificarPagamentoAnterior($id_cliente, $antigo_pagamento["data_inicio"]);
                if ($atrasado) {
                    throw new Exception("Existem pagamentos anteriores que precisam ser pagos primeiro.");
                }
                $clienteDados = $clienteModel->findId($id_cliente);
                $planoDados = $planoModel->findId($clienteDados["id_plano"]);

                $primeira_data_inicio = new DateTime($antigo_pagamento["data_vencimento"]);

                for ($i = 0; $i < $planoDados["duracao_meses"]; $i++) {

                    $valor = round(
                        $planoDados["valor"] / $planoDados["duracao_meses"],
                        2
                    );

                    $data_inicio = clone $primeira_data_inicio;
                    $data_inicio->modify("+$i month");
                    $data_vencimento = clone $data_inicio;
                    $data_vencimento->modify("+1 month");

                    $resultPagamento = $this->createPagamento([
                        "id_cliente" => $id_cliente,
                        "valor" => $valor,
                        "data_inicio" => $data_inicio->format("Y-m-d"),
                        "data_vencimento" => $data_vencimento->format("Y-m-d")
                    ]);

                    if (!$resultPagamento) {
                        throw new PDOException("Erro ao criar pagamento");
                    }
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
    }


    public function verificacao(string $data_vencimento, int $id_cliente): bool
    {
        $sql = "SELECT COUNT(*) AS verifica
        FROM pagamentos
        WHERE id_cliente = :id_cliente
        AND data = :data_vencimento
        AND status = 'PAGO'
    ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':id_cliente' => $id_cliente,
            ':data_vencimento' => $data_vencimento
        ]);

        return (int) $stmt->fetch()['verifica'] > 0;
    }
}
