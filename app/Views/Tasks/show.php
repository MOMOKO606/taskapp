<?= $this->extend("layouts/default") ?>

<?= $this->section("title") ?>  Hahaha!  <?= $this->endSection() ?>

<?= $this->section("content") ?>


<h1 class="title">Task</h1>

<a href="<?= site_url("/tasks")?>">&laquo; back to index</a>

<div class="content">

    <dl>
        <dt class="has-text-weight-bold">ID</dt>
        <dd><?= $task->id ?></dd>

        <dt class="has-text-weight-bold">Description</dt>
        <dd><?= esc($task->description) ?></dd>

        <dt class="has-text-weight-bold">Created at</dt>
        <dd><?= $task->created_at ?></dd>

        <dt class="has-text-weight-bold">Updated at</dt>
        <dd><?= $task->updated_at ?></dd>
    </dl>
</div>

<a href="<?= site_url("/tasks/edit/" . $task -> id )?>"> Edit</a>
<a href="<?= site_url("/tasks/delete/" . $task -> id )?>"> Delete</a>

<?= $this->endSection() ?>
