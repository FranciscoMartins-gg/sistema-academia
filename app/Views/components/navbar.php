
<nav class="navbar">

    <div class="logo">
        <div class="logo-icon">🏋️</div>

        <div>
            <strong>GYM</strong>
            <span>MANAGER</span>
        </div>
    </div>

    <div class="menu">

        <a href="/"
           class="<?= $pagina === 'dashboard' ? 'active' : '' ?>">
            Dashboard
        </a>

        <a href="/clientes"
           class="<?= $pagina === 'clientes' ? 'active' : '' ?>">
            Clientes
        </a>

        <a href="/acessos"
           class="<?= $pagina === 'acessos' ? 'active' : '' ?>">
            Acessos
        </a>

        <a href="/planos"
           class="<?= $pagina === 'planos' ? 'active' : '' ?>">
            Planos
        </a>

        <a href="/pagamentos"
           class="<?= $pagina === 'pagamentos' ? 'active' : '' ?>">
            Pagamentos
        </a>

    </div>

</nav>