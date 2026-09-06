<?php

namespace App\Controllers;

use App\Helpers\Logger;
use App\Models\PlanoModel;
use PDOException;

class PlanoController
{
    private PlanoModel $planoModel;
    public function __construct()
    {
        $this->planoModel = new PlanoModel();
    }
    public function index()
    {
        $planos = $this->planoModel->findAll();
        require_once __DIR__ . '/../Views/planos/index.php';
    }


    public function editar()
{
    try {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (
                !isset($_POST['id_plano']) ||
                !filter_var($_POST['id_plano'], FILTER_VALIDATE_INT)
            ) {
                $_SESSION['error'] = 'Plano inválido.';
                header('Location: /planos');
                exit;
            }

            $id_plano = (int) $_POST['id_plano'];

            $result = $this->planoModel->update([
                'id_plano' => $id_plano,
                'nome_plano' => trim($_POST['nome_plano']),
                'valor' => (float) $_POST['valor'],
                'duracao_meses' => (int) $_POST['duracao_meses'],
            ]);

            if ($result) {
                $_SESSION['success'] = 'Plano atualizado com sucesso!';
            } else {
                $_SESSION['error'] = 'Não foi possível atualizar o plano.';
            }

            header('Location: /planos');
            exit;
        }

        if (
            !isset($_GET['id_plano']) ||
            !filter_var($_GET['id_plano'], FILTER_VALIDATE_INT)
        ) {
            $_SESSION['error'] = 'Plano não informado.';
            header('Location: /planos');
            exit;
        }

        $id_plano = (int) $_GET['id_plano'];

        $plano = $this->planoModel->findId($id_plano);

        if (!$plano) {
            $_SESSION['error'] = 'Plano não encontrado.';
            header('Location: /planos');
            exit;
        }

        require_once __DIR__ . '/../Views/planos/editar.php';

    } catch (PDOException $e) {

        Logger::erro($e->getMessage());

        $_SESSION['error'] = 'Erro ao atualizar plano.';

        header('Location: /planos');
        exit;
    }
}


    public function create()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                require_once __DIR__ . '/../Views/planos/cadastrar.php';
                return;
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                if (
                    empty($_POST['nome_plano']) ||
                    empty($_POST['valor']) ||
                    empty($_POST['duracao_meses']) 
                ) {
                    $_SESSION['error'] = 'Preencha todos os campos.';
                    header('Location: /planos/cadastrar');
                    exit;
                }

                $result = $this->planoModel->create([
                    'nome_plano' => trim($_POST['nome_plano']),
                    'valor' => (float) $_POST['valor'],
                    'duracao_meses' => (int) $_POST['duracao_meses'],
                ]);

                if ($result) {
                    $_SESSION['success'] = 'Plano cadastrado com sucesso!';
                } else {
                    $_SESSION['error'] = 'Não foi possível cadastrar o plano.';
                }
                header('Location: /planos');
                exit;
            }
            require_once __DIR__ . '/../Views/planos/cadastrar.php';
        } catch (PDOException $e) {
        Logger::erro($e->getMessage());

        $_SESSION['error'] = 'Erro ao cadastrar plano.';

        header('Location: /planos');
        exit;
    }
    }
}
