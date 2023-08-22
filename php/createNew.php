<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>To-Do List</title>
</head>
<body class="create-todo-list-page">
<?php include '../classes/navbar.php'; ?>

    <div class="create-todo-list-container">
        <h1 class="create-todo-list-header">Create New To-Do List</h1>
        <form method="POST" action="addTask.php">
            <label class="create-todo-list-label" for="task1">Name:</label>
            <input class="create-todo-list-input" type="text" id="task1" name="task1" placeholder="Name the list">
            
            <label class="create-todo-list-label" for="task2">Description:</label>
            <input class="create-todo-list-input" type="text" id="task2" name="task2" placeholder="What needs to be done?">
            
            <input class="create-todo-list-submit" type="submit" value="Create List">
        </form>
    </div>
</body>
</html>
