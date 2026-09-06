<?php

namespace App\Controllers;

use App\Helpers\Logger;
use App\Models\AcessoModel;
use App\Models\ClienteModel;
use PDOException;

class AcessoController
{
    private ClienteModel $clienteModel;
    private AcessoModel $acessoModel;

    public function __construct()
    {
        $this->clienteModel = new ClienteModel();
        $this->acessoModel = new AcessoModel();
    }

    public function index()
    {
        try {
            $clientes = $this->clienteModel->findAll();

            $clienteSelecionado = null;
            $acessoAberto = null;
            $acessos = [];

            if (!empty($_GET['id_cliente'])) {
                $id_cliente = filter_var($_GET['id_cliente'], FILTER_VALIDATE_INT);

                if ($id_cliente) {
                    $clienteSelecionado = $this->clienteModel->findId($id_cliente);

                    if (!$clienteSelecionado) {
                        $_SESSION['error'] = 'Cliente não encontrado.';
                        header('Location: /acessos');
                        exit;
                    }

                    $acessoAberto = $this->acessoModel->findAberto($id_cliente);
                    $acessos = $this->acessoModel->findByCliente($id_cliente);
                }
            }

            require_once __DIR__ . '/../Views/acessos/index.php';
        } catch (PDOException $e) {
            Logger::erro($e->getMessage());

            $_SESSION['error'] = 'Erro ao carregar os acessos.';
            header('Location: /dashboard');
            exit;
        }
    }

    public function entrada()
    {
        try {
            if (
                !isset($_POST['id_cliente']) ||
                !filter_var($_POST['id_cliente'], FILTER_VALIDATE_INT)
            ) {
                $_SESSION['error'] = 'Cliente inválido.';
                header('Location: /acessos');
                exit;
            }

            $id_cliente = $_POST["id_cliente"];
            $result = $this->acessoModel->create($id_cliente);

            if($result){
                $_SESSION['success'] = 'Entrada registrada com sucesso!';
            }else{
                $_SESSION['error'] = 'Error ao registrar entrada';
            }
            header('Location: /acessos');
            exit;
        } catch (PDOException $e) {
            Logger::erro($e->getMessage());

            $_SESSION['error'] = 'Erro ao carregar os acessos.';
            header('Location: /acessos');
            exit;
        }
    }

    public function saida()
    {
        try {
            if (
                !isset($_POST['id_acesso']) ||
                !filter_var($_POST['id_acesso'], FILTER_VALIDATE_INT)
            ) {
                $_SESSION['error'] = 'Cliente inválido.';
                header('Location: /acessos');
                exit;
            }

            $id_acesso = $_POST["id_acesso"];
            $result = $this->acessoModel->updateAcesso($id_acesso);

            if($result){
                $_SESSION['success'] = 'Saída registrada com sucesso!';
            }else{
                $_SESSION['error'] = 'Error ao registrar saída';
            }
            header('Location: /acessos');
            exit;
        } catch (PDOException $e) {
            Logger::erro($e->getMessage());

            $_SESSION['error'] = 'Erro ao carregar os acessos.';
            header('Location: /acessos');
            exit;
        }
    }
}
