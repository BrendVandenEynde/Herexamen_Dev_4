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
    <?php
    include_once("../inc/bootstrap.php");

    // Check if the user is authenticated and the user ID is set in the session
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];
    } else {
        // Redirect or show an error message
        header("Location: login.php"); // Redirect to login page if user is not authenticated
        exit();
    }

    $db = Db::getInstance();
    $taskManager = new TaskManager($db);

    if (isset($_GET['list_id']) && is_numeric($_GET['list_id'])) {
        $listId = intval($_GET['list_id']);

        // Check if the list belongs to the logged-in user
        $list = $taskManager->getListById($listId, $userId);
        if (!$list) {
            echo "<p>You don't have permission to access this list.</p>";
            exit();
        }
    } else {
        echo "<p>Invalid list ID.</p>";
        exit();
    }
    ?>
    <form method="post" action="addTask.php">
        <input type="hidden" name="list" value="<?= $listId ?>">
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
