<?php
/** @var array $clientes */
/** @var array $acessos */
$pagina = "acessos";
$menu = "listar";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Acessos</title>
    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="/css/components/navbar.css">
    <link rel="stylesheet" href="/css/components/menu.css">
    <link rel="stylesheet" href="/css/components/alert.css">
    <link rel="stylesheet" href="/css/acessos/acesso.css">
</head>
<body>
<?php require __DIR__ . "/../components/navbar.php"; ?>
<?php require __DIR__ . "/../components/alert.php"; ?>

<main class="acessos-layout">

    <section class="acessos-content">

        <div class="acesso-topo">
            <form action="/acessos" method="GET">
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
            </form>
        </div>

        <?php if (!empty($clienteSelecionado)): ?>

            <div class="cliente-card">

                <div class="cliente-info">
                    <h2><?= htmlspecialchars($clienteSelecionado['nome_cliente']) ?></h2>
                </div>

                <div class="acesso-status">

                    <?php if (!empty($acessoAberto)): ?>

                        <span class="status dentro">● Dentro da academia</span>

                        <p>
                            Entrada:
                            <?= date('d/m/Y H:i', strtotime($acessoAberto['hora_entrada'])) ?>
                        </p>

                        <form action="/acessos/saida" method="POST">
                            <input type="hidden" name="id_acesso" value="<?= $acessoAberto['id_acesso'] ?>">

                            <button type="submit" class="btn-saida">
                                Registrar saída
                            </button>
                        </form>

                    <?php else: ?>

                        <span class="status fora">● Fora da academia</span>

                        <form action="/acessos/entrada" method="POST">
                            <input type="hidden" name="id_cliente" value="<?= $clienteSelecionado['id_cliente'] ?>">

                            <button type="submit" class="btn-entrada">
                                Registrar entrada
                            </button>
                        </form>

                    <?php endif; ?>

                </div>

            </div>

            <?php if (!empty($acessos)): ?>

                <div class="acessos-tabela">

                    <table>
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Entrada</th>
                                <th>Saída</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php foreach ($acessos as $acesso): ?>

                                <tr>
                                    <td>
                                        <?= date('d/m/Y', strtotime($acesso['hora_entrada'])) ?>
                                    </td>

                                    <td>
                                        <?= date('H:i', strtotime($acesso['hora_entrada'])) ?>
                                    </td>

                                    <td>
                                        <?php if (!empty($acesso['hora_saida'])): ?>
                                            <?= date('H:i', strtotime($acesso['hora_saida'])) ?>
                                        <?php else: ?>
                                            <span class="sem-saida">Em aberto</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>

                            <?php endforeach; ?>

                        </tbody>
                    </table>

                </div>

            <?php endif; ?>

        <?php else: ?>

            <div class="mensagem-selecione">
                <span>🚪</span>
                <p>Selecione um cliente para visualizar os acessos.</p>
            </div>

        <?php endif; ?>

    </section>
</main>

</body>
</html>