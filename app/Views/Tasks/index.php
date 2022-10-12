<?= $this->extend("layouts/default") ?>

<?= $this->section("title") ?>  Hahaha!  <?= $this->endSection() ?>

<?= $this->section("content") ?>
<h1> Task1 </h1>

<a href="<?= site_url("tasks/new")?>">New Task</a>
<ul>
    <?php foreach ($tasks as $task): ?>
    <li>
        <a href= "<?= site_url("/tasks/show/" . $task -> id)?>">
        <?=  esc($task -> description) ?>
        </a>
    </li>
    <?php endforeach; ?>
</ul>
<?= $this->endSection() ?>