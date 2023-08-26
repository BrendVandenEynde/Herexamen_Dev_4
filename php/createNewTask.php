<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Create New Task</title>
</head>
<body class="create-todo-list-page">
<?php include '../inc/nav.inc.php'; ?>

<div class="create-todo-list-container">
    <h1 class="create-todo-list-header">Create New Task</h1>
    <form method="post" action="addTask.php">
        <label class="create-todo-list-label" for="list">Choose List:</label>
        <select class="create-todo-list-input" id="list" name="list" required>
            <?php foreach ($lists as $list) : ?>
                <option value="<?= $list['id']; ?>"><?= $list['name']; ?></option>
            <?php endforeach; ?>
        </select><br><br>
        <label class="create-todo-list-label" for="name">Name:</label>
        <input class="create-todo-list-input" type="text" id="name" name="name" required><br><br>
        <label class="create-todo-list-label" for="description">Description:</label>
        <textarea class="create-todo-list-input" id="description" name="description" required></textarea><br><br>
        <label class="create-todo-list-label" for="deadline">Deadline:</label>
        <input class="create-todo-list-input" type="date" id="deadline" name="deadline" required><br><br>
        <input class="create-todo-list-submit" type="submit" value="Create Task">
    </form>
</div>
</body>
</html>
