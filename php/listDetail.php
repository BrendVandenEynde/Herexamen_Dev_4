<?php
include_once("../inc/bootstrap.php");

// Check if the 'id' parameter is provided in the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Get the list ID from the URL
    $listID = $_GET['id'];

    // Get a database instance
    $db = Db::getInstance();

    // Query to retrieve the list details
    $listQuery = "SELECT * FROM lists WHERE id = :list_id";
    $listStmt = $db->prepare($listQuery);
    $listStmt->bindParam(':list_id', $listID);
    $listStmt->execute();
    $list = $listStmt->fetch(PDO::FETCH_ASSOC);

    // Query to retrieve tasks for the list
    $tasksQuery = "SELECT * FROM tasks WHERE list_id = :list_id";
    $tasksStmt = $db->prepare($tasksQuery);
    $tasksStmt->bindParam(':list_id', $listID);
    $tasksStmt->execute();
    $tasks = $tasksStmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="../images/DefFaviconPortPixel.svg">
    <link rel="stylesheet" href="../css/style.css">
    <title>List Detail</title>
</head>
<body>
    <?php include '../inc/nav.inc.php'; ?>

    <div class="container" id="list-detail-container">
        <?php if ($list) : ?>
            <h1 id="list-detail-title">List Details: <?= $list['name']; ?></h1>
            <?php if (!empty($tasks)) : ?>
                <div class="task-list">
                    <h2>Incomplete Tasks</h2>
                    <ul class="incomplete-task-list">
                        <?php foreach ($tasks as $task) : ?>
                            <?php if (!$task['completed']) : ?>
                                <li class="task-item" id="task-item">
                                    <h3 class="task-name"><?= $task['name']; ?></h3>
                                    <p class="task-description"><?= $task['deadline']; ?></p>
                                    <a href="../php/taskDetail.php?id=<?= $task['id']; ?>" class="task-link">
                                        <button class="view-task-button">View Task</button>
                                    </a>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                <div class="completed-task-list">
                    <h2>Completed Tasks</h2>
                    <?php $completedTasks = array_filter($tasks, function($task) { return $task['completed']; }); ?>
                    <?php if (!empty($completedTasks)) : ?>
                        <ul>
                            <?php foreach ($completedTasks as $task) : ?>
                                <li class="task-item" id="task-item">
                                    <h3 class="task-name"><?= $task['name']; ?></h3>
                                    <p class="task-description"><?= $task['deadline']; ?></p>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else : ?>
                        <p class="no-completed-tasks-message">We haven't found any completed lists me boy</p>
                    <?php endif; ?>
                </div>
            <?php else : ?>
                <p class="no-tasks-message" id="no-tasks-message">Arrr, what's this? There be no tasks on this list, it's empty! We have been taken fools mateys!</p>
            <?php endif; ?>
            <div class="center-text">
                    <form method="post">
                        <button type="submit" name="delete-list" class="delete-list-button">Delete List</button>
                    </form>
                </div>
        <?php else : ?>
            <p class="error-message" id="error-message">Oops! we didn't seem to get the list of ye.</p>
        <?php endif; ?>
    </div>
</body>
</html>