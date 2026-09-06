<?php

/** @var string $menu */
/** @var array $planos */
/** @var array $cliente */

$pagina = "clientes";
$menu = "cadastrar";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastar Cliente</title>
    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="/css/components/navbar.css">
    <link rel="stylesheet" href="/css/components/menu.css">
    <link rel="stylesheet" href="/css/components/alert.css">
    <link rel="stylesheet" href="/css/clientes/cadastrar.css">
</head>

<body>
    <?php require __DIR__ .  "/../components/navbar.php"; ?>
    <?php require __DIR__ .  "/../components/alert.php"; ?>

    <div class="clientes-layout">
        <?php require __DIR__ .  "/../components/menu.php"; ?>

        <!-- FORMULÁRIO -->
        <main class="clientes-content">

            <div class="cliente-form">

                <h1>Atualizar Cliente</h1>

                <form action="/clientes/editar" method="POST">
                    <input
                        type="hidden"
                        name="id_cliente"
                        value="<?= $cliente['id_cliente'] ?>">
                    <div class="form-grid">
                        <div class="form-group">
                            <input
                                type="text"
                                id="nome"
                                name="nome_cliente"
                                value="<?= $cliente["nome_cliente"] ?>"
                                required>
                        </div>
                        <div class="form-group">
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="<?= $cliente["email"] ?>"
                                required>
                        </div>
                        <div class="form-group">
                            <input
                                type="text"
                                id="telefone"
                                name="telefone"
                                value="<?= $cliente["telefone"] ?>"
                                required>
                        </div>
                        <div class="form-group">
                            <select id="plano" name="id_plano" required>
                                <option value="">
                                    Selecione um plano
                                </option>
                                <?php foreach ($planos as $plano): ?>
                                    <option value="<?= $plano['id_plano'] ?>" <?= $cliente["id_plano"] === $plano["id_plano"] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($plano['nome_plano']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <select id="status" name="status">
                                <option value="ATIVO" <?= $cliente["status"] === "ATIVO" ? 'selected' : '' ?>>
                                    Ativo
                                </option>
                                <option value="INATIVO" <?= $cliente["status"] === "INATIVO" ? 'selected' : '' ?>>
                                    Inativo
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-buttons">
                        <a href="/clientes" class="btn-cancelar">
                            Cancelar
                        </a>
                        <button type="submit" class="btn-cadastrar">
                            Atualizar Cliente
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>

</html>