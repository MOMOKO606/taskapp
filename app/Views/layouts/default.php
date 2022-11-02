<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= $this->renderSection("title") ?></title>
</head>
<body>

<a href="<?= site_url("/") ?>">Home</a>

<?php if (current_user()): ?>

    <p>Hello <?= esc(current_user()->name) ?></p>

    <?php if (current_user()->is_admin): ?>

        <a href="<?= site_url("/admin/users") ?>">Users</a>

    <?php endif; ?>

    <a href="<?= site_url("/tasks") ?>">Tasks</a>

    <a href="<?= site_url("/logout") ?>">Log out</a>



<?php else: ?>

    <a href="<?= site_url("/signup") ?>">Sign up</a>

    <a href="<?= site_url("/login") ?>">Log in</a>

<?php endif; ?>

<?php if (session()->has('warning')): ?>
    <div class="warning">
        <?= session('warning') ?>
    </div>
<?php endif; ?>

<?php if (session()->has('info')): ?>
    <div class="info">
        <?= session('info') ?>
    </div>
<?php endif; ?>

<?php if (session()->has('error')): ?>
    <div class="error">
        <?= session('error') ?>
    </div>
<?php endif; ?>

<?= $this->renderSection("content") ?>

</body>
</html>