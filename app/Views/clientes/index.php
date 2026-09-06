<?php

/** @var array $clientes */
$pagina = "clientes";
$menu = "listar";
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>clientes</title>
    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="/css/components/navbar.css">
    <link rel="stylesheet" href="/css/components/menu.css">
    <link rel="stylesheet" href="/css/components/alert.css">
    <link rel="stylesheet" href="/css/clientes/cliente.css">
</head>

<body>

    <?php require __DIR__ .  "/../components/navbar.php"; ?>
    <?php require __DIR__ .  "/../components/alert.php"; ?>

    <main class="clientes-container">

        <?php require __DIR__ .  "/../components/menu.php"; ?>

        <!-- CONTEÚDO -->
        <section class="clientes-content">

            <!-- BARRA DE PESQUISA -->
            <form action="/clientes" method="get">
                <div class="clientes-topo">
                    <input
                        type="text"
                        name="busca"
                        placeholder="Pesquisar cliente..."
                        class="pesquisa"
                        value="<?= htmlspecialchars($_GET["busca"] ?? '') ?>">
                </div>
            </form>

            <!-- TABELA -->
            <div class="clientes-tabela">
                <table>
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Plano</th>
                            <th>Telefone</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($clientes as $cliente): ?>
                            <tr>
                                <td><?= $cliente["nome_cliente"]; ?></td>
                                <td><?= $cliente["email"]; ?></td>
                                <td><?= $cliente["nome_plano"]; ?></td>
                                <td><?= $cliente["telefone"]; ?></td>
                                <td class="<?= $cliente["status"] === 'ATIVO' ? 'ativo-status' : 'desativado-status'; ?>"><?= $cliente["status"]; ?></td>

                                <td>
                                    <a class="acao" href="/clientes/editar?id_cliente=<?= $cliente["id_cliente"]; ?>">✏️</a>
                                    <a class="acao" href="/clientes/deletar?id_cliente=<?= $cliente["id_cliente"]; ?>">🗑️</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
    </div>
</body>

</html>