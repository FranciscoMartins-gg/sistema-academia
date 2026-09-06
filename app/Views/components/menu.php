  <!-- MENU LATERAL -->
        <aside class="clientes-menu">
            <a href="/<?= $pagina ?>" class="<?= $menu === "listar" ? 'ativo' : '' ?>">
                Listar <?= $pagina ?>
            </a>
            <a href="/<?= $pagina ?>/cadastrar " class="<?= $menu === "cadastrar" ? 'ativo' : '' ?>">
                Cadastrar <?= $pagina ?>
            </a>
        </aside>