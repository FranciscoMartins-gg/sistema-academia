<link rel="stylesheet" href="alet.css">
<?php if (isset($_SESSION['success'])): ?>

    <div class="alert alert-success">
        <?= htmlspecialchars($_SESSION['success']) ?>
    </div>

    <?php unset($_SESSION['success']); ?>

<?php endif; ?>


<?php if (isset($_SESSION['error'])): ?>

    <div class="alert alert-error">
        <?= htmlspecialchars($_SESSION['error']) ?>
    </div>

    <?php unset($_SESSION['error']); ?>

<?php endif; ?>