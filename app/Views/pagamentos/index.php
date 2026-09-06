<?php
/** @var array $clientes */
/** @var array $pagamentos */

$pagina = "pagamentos";
$menu = "listar";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Pagamentos</title>
    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="/css/components/navbar.css">
    <link rel="stylesheet" href="/css/components/menu.css">
    <link rel="stylesheet" href="/css/components/alert.css">
    <link rel="stylesheet" href="/css/pagamentos/pagamento.css">
</head>
<body>
<?php require __DIR__ . "/../components/navbar.php"; ?>
<?php require __DIR__ . "/../components/alert.php"; ?>

<main class="pagamentos-layout">

    <section class="pagamentos-content">

        <div class="pagamentos-topo">
            <form action="/pagamentos" method="GET">
                <div class="filtros">

                    <div class="filtro-cliente">
                        <label>Cliente:</label>
                        <select name="id_cliente" onchange="this.form.submit()">
                            <option value="">Selecione um cliente</option>

                            <?php foreach ($clientes as $cliente): ?>
                                <option value="<?= $cliente['id_cliente'] ?>"
                                    <?= isset($_GET['id_cliente']) && $_GET['id_cliente'] == $cliente['id_cliente'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cliente['nome_cliente']) ?>
                                </option>
                            <?php endforeach; ?>

                        </select>
                    </div>

                    <?php if (!empty($_GET['id_cliente'])): ?>

                        <div class="filtro-status">
                            <label>Status:</label>
                            <select name="status" onchange="this.form.submit()">
                                <option value="">Todas</option>
                                <option value="PAGO" <?= ($_GET['status'] ?? '') === 'PAGO' ? 'selected' : '' ?>>Pagas</option>
                                <option value="PENDENTE" <?= ($_GET['status'] ?? '') === 'PENDENTE' ? 'selected' : '' ?>>Pendentes</option>
                                <option value="ATRASADO" <?= ($_GET['status'] ?? '') === 'ATRASADO' ? 'selected' : '' ?>>Atrasadas</option>
                            </select>
                        </div>

                    <?php endif; ?>

                </div>
            </form>
        </div>

        <?php if (!empty($_GET['id_cliente'])): ?>

            <div class="pagamentos-tabela">
                <table>
                    <thead>
                        <tr>
                            <th>Vencimento</th>
                            <th>Valor</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($pagamentos as $pagamento): ?>

                            <tr>
                                <td>
                                    <?= date('d/m/Y', strtotime($pagamento['data_vencimento'])) ?>
                                </td>

                                <td>
                                    R$ <?= number_format((float)$pagamento['valor'], 2, ',', '.') ?>
                                </td>

                                <td>
                                    <?php if ($pagamento['status'] === 'Pago'): ?>
                                        <span class="status pago">PAGO</span>
                                    <?php elseif ($pagamento['status'] === 'Atrasado'): ?>
                                        <span class="status atrasado">ATRASADO</span>
                                    <?php else: ?>
                                        <span class="status pendente">PENDENTE</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php if ($pagamento['status'] !== 'Pago'): ?>
                                        <form action="/pagamentos/pagar" method="POST">
                                            <input type="hidden" name="id_pagamento" value="<?= $pagamento['id_pagamento'] ?>">
                                            <button type="submit" class="btn-pagar">
                                                Pagar
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <span class="pago-icon">✓</span>
                                    <?php endif; ?>
                                </td>
                            </tr>

                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?php else: ?>

            <div class="mensagem-selecione">
                <span>💳</span>
                <p>Selecione um cliente para visualizar as parcelas.</p>
            </div>

        <?php endif; ?>

    </section>
</main>
</body>
</html>