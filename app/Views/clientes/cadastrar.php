<?php
/** @var string $menu */
/** @var array $planos */

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

            <h1>Cadastrar Cliente</h1>

            <form action="/clientes/cadastrar" method="POST">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="nome">
                            👤 Nome Cliente:
                        </label>
                        <input
                            type="text"
                            id="nome"
                            name="nome_cliente"
                            placeholder="Digite o nome do cliente"
                            required
                        >
                    </div>
                    <div class="form-group">
                        <label for="email">
                            ✉ E-mail:
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="Digite o e-mail"
                            required
                        >
                    </div>
                    <div class="form-group">
                        <label for="telefone">
                            📞 Telefone:
                        </label>

                        <input
                            type="text"
                            id="telefone"
                            name="telefone"
                            placeholder="(00) 00000-0000"
                            required
                        >
                    </div>
                    <div class="form-group">
                        <label for="plano">
                            📋 Plano:
                        </label>
                        <select id="plano" name="id_plano" required>
                            <option value="">
                                Selecione um plano
                            </option>
                            <?php foreach ($planos as $plano): ?>
                                <option value="<?= $plano['id_plano'] ?>">
                                    <?= htmlspecialchars($plano['nome_plano']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">
                            🔵 Status:
                        </label>
                        <select id="status" name="status">
                            <option value="ATIVO">
                                Ativo
                            </option>
                            <option value="INATIVO">
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
                        Cadastrar Cliente
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>

    </body>
</html>