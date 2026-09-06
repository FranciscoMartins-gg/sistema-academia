<?php
/** @var array $plano */
$pagina = "planos";
$menu = "cadastrar";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Plano</title>
    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="/css/components/navbar.css">
    <link rel="stylesheet" href="/css/components/menu.css">
    <link rel="stylesheet" href="/css/components/alert.css">
    <link rel="stylesheet" href="/css/planos/editar.css">
</head>
<body>
<?php require __DIR__ . "/../components/navbar.php"; ?>
<?php require __DIR__ . "/../components/alert.php"; ?>
<main class="planos-layout">
    <?php require __DIR__ . "/../components/menu.php"; ?>
    <section class="plano-form">
        <h1>Atualizar Plano</h1>
        <form action="/planos/editar" method="POST">
            <input type="hidden" name="id_plano" value="<?= $plano["id_plano"] ?>" required>
            <div class="form-grid">
                <div class="form-group">
                    <input type="text" name="nome_plano" value="<?= $plano["nome_plano"] ?>" required>
                </div>
                <div class="form-group">
                    <input type="number" name="valor" value="<?= $plano["valor"] ?>" step="0.01" min="0" required>
                </div>
                <div class="form-group">
                    <label>📅 Duração:</label>
                    <input type="number" name="duracao_meses" value="<?= $plano["duracao_meses"] ?>" min="1" required>
                </div>
            </div>
            <div class="form-buttons">
                <a href="/planos" class="btn-cancelar">Cancelar</a>
                <button type="submit" class="btn-cadastrar">Atualizar Plano</button>
            </div>
        </form>
    </section>
</main>
</body>
</html>