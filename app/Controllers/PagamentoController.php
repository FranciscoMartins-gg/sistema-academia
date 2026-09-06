<?php

namespace App\Controllers;

use App\Helpers\Logger;
use App\Models\ClienteModel;
use App\Models\PagamentoModel;
use PDOException;

class PagamentoController
{
    private ClienteModel $clienteModel;
    private PagamentoModel $pagamentoModel;

    public function __construct()
    {
        $this->clienteModel = new ClienteModel();
        $this->pagamentoModel = new PagamentoModel();
    }

    public function index()
    {
        try {
            $clientes = $this->clienteModel->findAll();

            $pagamentos = [];

            if (!empty($_GET['id_cliente'])) {
                $id_cliente = filter_var($_GET['id_cliente'], FILTER_VALIDATE_INT);

                if ($id_cliente) {
                    $status = $_GET['status'] ?? '';

                    $pagamentos = $this->pagamentoModel->findByCliente(
                        $id_cliente,
                        $status
                    );
                }
            }

            require_once __DIR__ . '/../Views/pagamentos/index.php';
        } catch (PDOException $e) {
            Logger::erro($e->getMessage());

            $_SESSION['error'] = 'Erro ao carregar os pagamentos.';
            header('Location: /pagamentos');
            exit;
        }
    }


    public function pagar()
    {
        try {

            if (
                !isset($_POST['id_pagamento']) ||
                !filter_var($_POST['id_pagamento'], FILTER_VALIDATE_INT)
            ) {
                $_SESSION['error'] = 'Pagamento inválido.';
                header('Location: /pagamentos');
                exit;
            }

            $id_pagamento = $_POST["id_pagamento"];

            $result = $this->pagamentoModel->pagar($id_pagamento);
            if ($result) {
                $_SESSION['success'] = 'Pagamento efetuado com sucesso';
            } else {
                $_SESSION['error'] = 'Erro ao efetuar pagamento';
            }

            header('Location: /pagamentos');
            exit;
        } catch (PDOException $e) {
            Logger::erro($e->getMessage());

            $_SESSION['error'] = 'Erro ao carregar os pagamentos.';
            header('Location: /pagamentos');
            exit;
        }
    }
}
