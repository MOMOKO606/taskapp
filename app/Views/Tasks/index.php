<?= $this->extend("layouts/default") ?>

<?= $this->section("title") ?>Tasks<?= $this->endSection() ?>

<?= $this->section("content") ?>

    <h1>Tasks</h1>

    <a href="<?= site_url("/tasks/new") ?>">New task</a>

    <div>
        <label for="query">Search</label>
        <input name="query" id="query">
    </div>


<?php if ($tasks): ?>

    <ul>
        <?php foreach($tasks as $task): ?>

            <li>
                <a href="<?= site_url("/tasks/show/" . $task->id) ?>">
                    <?= esc($task->description) ?>
                </a>
            </li>

        <?php endforeach; ?>
    </ul>
    <?= $pager->links()?>

<?php else: ?>

    <p>No tasks found.</p>

<?php endif; ?>
<script src="<?= base_url('/js/auto-complete.min.js') ?>"></script>

<script>
    var searchUrl = "<?= site_url('/tasks/search?q=') ?>";

    var searchAutoComplete = new autoComplete({
        selector: 'input[name="query"]',
        cache: false,
        source: function(term, response) {

            var request = new XMLHttpRequest();

            request.open('GET', searchUrl + term, true);

            request.onload = function() {

                data = JSON.parse(this.response);

                var suggestions = data.map(task => task.description);

                response(suggestions);
            };

            request.send();
        }
    });

</script>

<?= $this->endSection() ?>