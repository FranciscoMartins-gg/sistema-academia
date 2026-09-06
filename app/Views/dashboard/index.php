<?php
$pagina = "dashboard";
/** @var array $dados */
/** @var array $clientes_entrada */
/** @var array $clientes_pagamentos_atrasados */
/** @var string  $pagina*/
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>dashboard</title>
    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="/css/components/navbar.css">
    <link rel="stylesheet" href="/css/dashboard/dashboard.css">
</head>

<body>

    <div class="container">

        <?php require __DIR__ .  "/../components/navbar.php"; ?>


        <!-- CONTEÚDO -->
        <main class="dashboard">

            <!-- CARDS -->
            <section class="cards">

                <div class="card">

                    <div class="card-icon">👥</div>

                    <div class="card-info">
                        <span>Clientes</span>
                        <strong><?= $dados["clientes_totais"]; ?></strong>
                    </div>

                </div>


                <div class="card">

                    <div class="card-icon">💳</div>

                    <div class="card-info">
                        <span>Planos ativos</span>
                        <strong><?= $dados["cliente_planos_ativos"]; ?> </strong>
                    </div>

                </div>


                <div class="card">

                    <div class="card-icon">💲</div>

                    <div class="card-info">
                        <span>Receita</span>
                        <strong><?= number_format($dados["receita"], "2", ",", "."); ?>$</strong>
                    </div>

                </div>


                <div class="card">

                    <div class="card-icon">📋</div>

                    <div class="card-info">
                        <span>Entradas</span>
                        <strong><?= $dados["acessos"]; ?></strong>
                    </div>

                </div>

            </section>


            <!-- PARTE INFERIOR -->
            <section class="bottom">

                <!-- ÚLTIMOS CLIENTES -->
                <div class="panel clientes">

                    <h2>Últimos Clientes</h2>
                    <?php foreach ($clientes_entrada as $clientes): ?>
                        <div class="cliente">

                            <span><?= $clientes["nome_cliente"]; ?></span>

                            <span class="hora"><?= $clientes["hora_entrada"]; ?></span>

                            <span class="entrada">Entrada</span>

                        </div>
                    <?php endforeach; ?>

                </div>


                <!-- PAGAMENTOS ATRASADOS -->
                <div class="panel atrasados">

                    <h2>Pagamentos Atrasados</h2>
                    <?php foreach ($clientes_pagamentos_atrasados as $clientes): ?>
                        <div class="pagamento">
                            <?php echo $clientes["nome_cliente"] . " - " . number_format($clientes["valor"], "2", ",", ".") . " - " . $clientes["quantidade_atrasada"] . "x"; ?>
                        </div>
                    <?php endforeach; ?>

                </div>

            </section>

        </main>

    </div>
</body>

</html>