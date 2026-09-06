<?php
/** @var array $planos */
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
    <link rel="stylesheet" href="/css/planos/cadastrar.css">
</head>

<body>

<?php require __DIR__ . "/../components/navbar.php"; ?>
<?php require __DIR__ . "/../components/alert.php"; ?>

<main class="planos-layout">

    <?php require __DIR__ . "/../components/menu.php"; ?>

    <section class="plano-form">

        <h1>Cadastrar Plano</h1>

        <form action="/planos/cadastrar" method="POST">

            <div class="form-grid">

                <div class="form-group">
                    <label>📋 Nome do Plano:</label>

                    <input
                        type="text"
                        name="nome_plano"
                        value="<?= htmlspecialchars($_GET["busca"] ?? '') ?>"
                        placeholder="Digite o nome do plano"
                        required>
                </div>

                <div class="form-group">
                    <label>💰 Valor:</label>

                    <input
                        type="number"
                        name="valor"
                        placeholder="Digite o valor do plano"
                        step="0.01"
                        min="0"
                        required>
                </div>

                <div class="form-group">
                    <label>📅 Duração:</label>

                    <input
                        type="number"
                        name="duracao_meses"
                        placeholder="Quantidade de meses"
                        min="1"
                        required>
                </div>
            </div>

            <div class="form-buttons">
                <a
                    href="/planos"
                    class="btn-cancelar">
                    Cancelar
                </a>

                <button
                    type="submit"
                    class="btn-cadastrar">
                    Cadastrar Plano
                </button>

            </div>

        </form>

    </section>

</main>

</body>
</html>