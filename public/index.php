<?php
session_start();
date_default_timezone_set('America/Bahia');
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\ClienteController;
use App\Models\AcessoModel;
use App\Models\ClienteModel;
use App\Models\PagamentoModel;
use App\Models\PlanoModel;
use Config\Database;
use Config\Migrations;


$pdo = Database::getConnection();
// Migrations::reset($pdo);
Migrations::load($pdo);

$plano = new PlanoModel();
$cliente = new ClienteModel();
$acesso = new AcessoModel();
$pagamento = new PagamentoModel();

// $acesso->update(3);
// $acesso->create(6);
// print_r($acesso->findAll());
// $plano->create(["nome_plano"=>"Gold", "valor"=>200, "duracao_meses"=>12]);
// $plano->create(["nome_plano"=>"Silver", "valor"=>50, "duracao_meses"=>1]);
// $dados = $plano->findAll();
// print_r($dados);

// try {
//     $dados = $pagamento->findIdCliente(1);
//     foreach ($dados as $pagamentos) {
//         foreach ($pagamentos as $key => $valor) {
//             echo $key . ": " . $valor . " || ";
//         }
//         echo "</br>";
//     }
//     $pagamento->pagar(12);
    // $cliente->create(["id_plano"=>1, "nome_cliente"=>"Maria Eduarada", "email"=>"teste3@gmail.com", "telefone"=>"74-999274909", "status"=>"ATIVO"]);
// } catch (PDOException $th) {
//     echo $th;
// }
// print_r($cliente->findAll());


require_once __DIR__ . '/../routes/web.php';
