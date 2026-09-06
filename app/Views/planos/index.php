<?php
/** @var array $planos */
$pagina = "planos";
$menu = "listar";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Planos</title>
    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="/css/components/navbar.css">
    <link rel="stylesheet" href="/css/components/menu.css">
    <link rel="stylesheet" href="/css/components/alert.css">
    <link rel="stylesheet" href="/css/planos/plano.css">
</head>
<body>

<?php require __DIR__ . "/../components/navbar.php"; ?>
<?php require __DIR__ . "/../components/alert.php"; ?>

<main class="planos-container">

    <?php require __DIR__ . "/../components/menu.php"; ?>

    <section class="planos-content">
        <div class="planos-tabela">
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Valor</th>
                        <th>Duração</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($planos as $plano): ?>
                        <tr>
                            <td><?= htmlspecialchars($plano["nome_plano"]) ?></td>

                            <td>
                                R$ <?= number_format(
                                    (float) $plano["valor"],
                                    2,
                                    ',',
                                    '.'
                                ) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($plano["duracao_meses"]) ?>
                                <?= $plano["duracao_meses"] == 1 ? 'mês' : 'meses' ?>
                            </td>

                            <td>
                                <a
                                    class="acao"
                                    href="/planos/editar?id_plano=<?= $plano["id_plano"] ?>">
                                    ✏️
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </section>

</main>

</body>
</html>