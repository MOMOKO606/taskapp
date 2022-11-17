<!DOCTYPE html>
<html>
<head>
    <!-- 使用css bulma framework  -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->renderSection("title") ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css"
          integrity="sha256-WLKGWSIJYerRN8tbNGtXWVYnUM5wMJTXD8eG4NtGcDM=" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="<?= base_url('/css/auto-complete.css') ?>">
</head>
<body>
<!--加入框架的section class，继承body class-->
<section class="section">

    <nav class="navbar" role="navigation" aria-label="main navigation">

        <div class="navbar-menu">

            <div class="navbar-start">

                <a class="navbar-item" href="<?= site_url("/") ?>">Home</a>

            </div>

            <div class="navbar-end">

                <?php if (current_user()): ?>

                    <div class="navbar-item">Hello <?= esc(current_user()->name) ?></div>

                    <a class="navbar-item" href="<?= site_url("/profile/show") ?>">Profile</a>

                    <?php if (current_user()->is_admin): ?>

                        <a class="navbar-item" href="<?= site_url("/admin/users") ?>">Users</a>

                    <?php endif; ?>

                    <a class="navbar-item" href="<?= site_url("/tasks") ?>">Tasks</a>

                    <a class="navbar-item" href="<?= site_url("/logout") ?>">Log out</a>

                <?php else: ?>

                    <a class="navbar-item" href="<?= site_url("/signup") ?>">Sign up</a>

                    <a class="navbar-item" href="<?= site_url("/login") ?>">Log in</a>

                <?php endif; ?>

            </div>
        </div>
    </nav>

    <!-- 用notification class from the Bulma framework, 美化flash notification messages   -->
    <?php if (session()->has('warning')): ?>
        <div class="notification is-warning is-light">
            <!--  加一个关闭  flash notification messages 的按钮          -->
            <!--  按钮功能放在public中的js/app.js          -->
            <button class="delete"></button>
            <?= session('warning') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->has('info')): ?>
        <div class="notification is-info is-light">
            <button class="delete"></button>
            <?= session('info') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->has('error')): ?>
        <div class="notification is-danger is-light">
            <button class="delete"></button>
            <?= session('error') ?>
        </div>
    <?php endif; ?>

    <?= $this->renderSection("content") ?>

</section>

<!--load the notification class-->
<script src="<?=  base_url('/js/app.js') ?>"></script>
</body>
</html>