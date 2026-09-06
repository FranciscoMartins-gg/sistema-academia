<?php

namespace App\Controllers;

use App\Helpers\Logger;
use App\Models\AcessoModel;
use App\Models\ClienteModel;
use App\Models\PagamentoModel;
use App\Models\PlanoModel;

class DashboardController
{

    private ClienteModel $clienteModel;
    private AcessoModel $acessoModel;
    private PagamentoModel $pagamentoModel;

    public function __construct()
    {
        $this->clienteModel = new ClienteModel();
        $this->acessoModel = new AcessoModel();
        $this->pagamentoModel = new PagamentoModel();
    }

    public function index()
    {
        try {
            $this->pagamentoModel->verificarPagamentosAtrasados();
            $dados = [
                'clientes_totais' => $this->clienteModel->count(),
                'cliente_planos_ativos' => $this->clienteModel->countActive(),
                'receita' => $this->clienteModel->countBudget(),
                'acessos' => $this->acessoModel->countToday()
            ];
            $clientes_entrada = $this->acessoModel->last();
            foreach ($clientes_entrada as  &$value) {
                $value["hora_entrada"] = date("H:i", strtotime($value["hora_entrada"]));
            }
            $clientes_pagamentos_atrasados = $this->pagamentoModel->atrasados();
            require_once __DIR__ . '/../Views/dashboard/index.php';
        } catch (\PDOException $e) {

            Logger::erro($e->getMessage());


            echo "Erro ao carregar o dashboard...";
        }
    }
}
