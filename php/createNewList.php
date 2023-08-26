<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Create New List</title>
</head>
<body class="create-todo-list-page">
<?php include '../inc/nav.inc.php'; ?>

    <div class="create-todo-list-container">
        <h1 class="create-todo-list-header">Create New List</h1>
        <form method="post" action="../classes/List.php" id="create-list-form">
            <label class="create-todo-list-label" for="name">Name:</label>
            <input class="create-todo-list-input" type="text" id="name" name="name" required><br><br>
            <label class="create-todo-list-label" for="description">Description:</label>
            <textarea class="create-todo-list-input" id="description" name="description" required></textarea><br><br>
            <input class="create-todo-list-submit" type="submit" value="Create List">
        </form>
    </div>
</body>
</html>
