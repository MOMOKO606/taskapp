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
    <script defer src="https://use.fontawesome.com/releases/v5.14.0/js/all.js"></script>
</head>
<body>
<!--加入框架的section class，继承body class-->
<section class="section">

    <nav class="navbar" role="navigation" aria-label="main navigation">

        <div class="navbar-menu">

            <div class="navbar-start">

                <a class="navbar-item" href="<?= site_url("/") ?>"><?= lang('App.nav.home') ?></a>

            </div>

            <div class="navbar-end">

                <?php if (current_user()): ?>

                    <div class="navbar-item"><?= lang('App.nav.hello') ?>, <?= esc(current_user()->name) ?></div>

                    <a class="navbar-item" href="<?= site_url("/profile/show") ?>"><?= lang('App.nav.profile') ?></a>

                    <?php if (current_user()->is_admin): ?>

                        <a class="navbar-item" href="<?= site_url("/admin/users") ?>"><?= lang('App.nav.users') ?></a>

                    <?php endif; ?>

                    <a class="navbar-item" href="<?= site_url("/tasks") ?>"><?= lang('App.nav.tasks') ?></a>

                    <a class="navbar-item" href="<?= site_url("/logout") ?>"><?= lang('App.nav.logout') ?></a>

                <?php else: ?>

                    <a class="navbar-item" href="<?= site_url("/$locale/signup") ?>"><?= lang('App.nav.signup') ?></a>

                    <a class="navbar-item" href="<?= site_url("/$locale/login") ?>"><?= lang('App.nav.login') ?></a>

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