<?php

namespace App\Controllers;

use App\Helpers\Logger;
use App\Models\ClienteModel;
use App\Models\PlanoModel;
use PDOException;

class ClienteController
{
    private ClienteModel $clienteModel;
    private PlanoModel $planoModel;

    public function __construct()
    {
        $this->clienteModel = new ClienteModel();
        $this->planoModel = new PlanoModel();
    }

    public function index()
    {
        $busca = $_GET["busca"] ?? '';

        $clientes = $this->clienteModel->findAll($busca);

        require_once __DIR__ . '/../Views/clientes/index.php';
    }

    public function cadastrar()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                $planos = $this->planoModel->findForSelect();
                require_once __DIR__ . '/../Views/clientes/cadastrar.php';
                return;
            }

              if (
                empty($_POST['nome_cliente']) ||
                empty($_POST['email']) ||
                empty($_POST['telefone']) ||
                empty($_POST['status']) ||
                empty($_POST['id_plano'])
            ) {
                $_SESSION['error'] = 'Preencha todos os campos.';
                header('Location: /clientes/cadastrar');
                exit;
            }


            $result = $this->clienteModel->create([
                'nome_cliente' => $_POST['nome_cliente'],
                'email' => $_POST['email'],
                'telefone' => $_POST['telefone'],
                'id_plano' => $_POST['id_plano'],
                'status' => $_POST['status']
            ]);

            if ($result) {
                $_SESSION['success'] = 'Cliente cadastrado com sucesso!';
            } else {
                $_SESSION['error'] = 'Falha ao tentar cadastrar cliente';
            }

            header('Location: /clientes');
            exit;
        } catch (PDOException $e) {
            Logger::erro($e->getMessage());
            $_SESSION['error'] = 'Erro ao cadastrar cliente!';

            header('Location: /clientes');
            exit;
        }
    }

    public function deletar()
    {
        try {
            if (
                !isset($_GET['id_cliente']) ||
                !filter_var($_GET['id_cliente'], FILTER_VALIDATE_INT)
            ) {
                $_SESSION['error'] = 'Cliente inválido.';
                header('Location: /clientes');
                exit;
            }

            $id_cliente = (int) $_GET['id_cliente'];

            $result = $this->clienteModel->delete($id_cliente);

            if ($result) {
                $_SESSION['success'] = 'Cliente excluído com sucesso!';
            } else {
                $_SESSION['error'] = 'Não foi possível excluir o cliente.';
            }

            header('Location: /clientes');
            exit;
        } catch (PDOException $e) {
            Logger::erro($e->getMessage());
            $_SESSION['error'] = 'Erro ao deletar cliente!';

            header('Location: /clientes');
            exit;
        }
    }

    public function editar()
    {
        try {

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                if (
                    !isset($_POST['id_cliente']) ||
                    !filter_var($_POST['id_cliente'], FILTER_VALIDATE_INT)
                ) {
                    $_SESSION['error'] = 'Cliente não informado.';
                    header('Location: /clientes');
                    exit;
                }

                $result = $this->clienteModel->update(
                    [
                        'id_cliente' => (int) $_POST['id_cliente'],
                        'nome_cliente' => $_POST['nome_cliente'] ?? '',
                        'email' => $_POST['email'] ?? '',
                        'telefone' => $_POST['telefone'] ?? '',
                        'id_plano' => (int) $_POST['id_plano'],
                        'status' => $_POST['status'] ?? ''
                    ]
                );
                if ($result) {
                    $_SESSION['success'] = 'Cliente atualizado com sucesso!';
                } else {
                    $_SESSION['error'] = 'Não foi possível atualizar o cliente!';
                }

                header('Location: /clientes');
                exit;
            }

            if (
                !isset($_GET['id_cliente']) ||
                !filter_var($_GET['id_cliente'], FILTER_VALIDATE_INT)
            ) {
                $_SESSION['error'] = 'Cliente não informado.';
                header('Location: /clientes');
                exit;
            }
            $id_cliente = (int)$_GET['id_cliente'] ?? '';

            $cliente = $this->clienteModel->findId($id_cliente);
            $planos = $this->planoModel->findForSelect();
            if (!$cliente) {
                $_SESSION['error'] = 'Cliente não encontrado.';
                header('Location: /clientes');
                exit;
            }

            require_once __DIR__ . '/../Views/clientes/editar.php';
        } catch (PDOException $e) {
            Logger::erro($e->getMessage());
            $_SESSION['error'] = 'Erro ao atualizar cliente!';

            header('Location: /clientes');
            exit;
        }
    }
}
