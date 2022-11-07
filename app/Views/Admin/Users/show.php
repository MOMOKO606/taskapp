<?= $this->extend('layouts/default') ?>

<?= $this->section('title') ?>User<?= $this->endSection() ?>

<?= $this->section('content') ?>

    <h1>User</h1>

    <a href="<?= site_url("/admin/users") ?>">&laquo; back to index</a>

    <dl>
        <dt>Name</dt>
        <dd><?= esc($user->name) ?></dd>

        <dt>Email</dt>
        <dd><?= esc($user->email) ?></dd>

        <dt>Active</dt>
        <dd><?= $user->is_active ? 'yes' : 'no' ?></dd>

        <dt>Administrator</dt>
        <dd><?= $user->is_admin ? 'yes' : 'no' ?></dd>

        <dt>Created at</dt>
        <dd><?= $user->created_at ?></dd>

        <dt>Updated at</dt>
        <dd><?= $user->updated_at ?></dd>
    </dl>

    <a href="<?= site_url('/admin/users/edit/' . $user->id) ?>">Edit</a>

<!--    检查被展示的用户id和当前登录用户id是否一致-->
    <?php if ($user->id != current_user()->id): ?>

        <a href="<?= site_url('/admin/users/delete/' . $user->id) ?>">Delete</a>

    <?php endif; ?>

<?= $this->endSection() ?>