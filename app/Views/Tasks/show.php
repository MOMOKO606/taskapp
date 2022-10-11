<?= $this->extend("layouts/default") ?>

<?= $this->section("title") ?>  Hahaha!  <?= $this->endSection() ?>

<?= $this->section("content") ?>
<h1> Task1 </h1>

<dl>
    <dt> ID </dt>
    <dd><?= $task["id"] ?></dd>

    <dt>Description</dt>
    <dd><?= $task["description"]?></dd>

    <dt>Created at</dt>
    <dd><?= $task["created_at"]?></dd>

    <dt>Updated at</dt>
    <dd><?= $task["updated_at"]?></dd>
</dl>


<?= $this->endSection() ?>
