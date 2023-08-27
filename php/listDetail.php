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

    // Handle list deletion
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete-list'])) {
        $deleteTasksQuery = "DELETE FROM tasks WHERE list_id = :list_id";
        $deleteTasksStmt = $db->prepare($deleteTasksQuery);
        $deleteTasksStmt->bindParam(':list_id', $listID);
        $deleteTasksStmt->execute();

        $deleteListQuery = "DELETE FROM lists WHERE id = :list_id";
        $deleteListStmt = $db->prepare($deleteListQuery);
        $deleteListStmt->bindParam(':list_id', $listID);

        if ($deleteListStmt->execute()) {
            header("Location: homePage.php"); 
            exit();
        } else {
            echo "<script>alert('An error occurred while deleting the list.');</script>";
        }
    }
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
       <!-- Display Incomplete Tasks -->
<div class="task-list">
    <h2>Incomplete Tasks</h2>
    <?php $incompleteTasks = array_filter($tasks, function($task) { return !$task['completed']; }); ?>
    <?php
    // Sort incomplete tasks by deadline in ascending order
    usort($incompleteTasks, function($a, $b) {
        return strtotime($a['deadline']) - strtotime($b['deadline']);
    });
    ?>
    <?php if (!empty($incompleteTasks)) : ?>
        <ul class="incomplete-task-list">
            <?php $counter = 0; ?>
            <?php foreach ($incompleteTasks as $task) : ?>
                <?php if ($counter % 5 == 0) : ?>
                    <div class="task-row">
                <?php endif; ?>
                <li class="task-item" id="task-item">
                    <h3 class="task-name"><?= $task['name']; ?></h3>
                    <p class="task-description"><?= $task['deadline']; ?></p>
                    <div class="task-buttons center-text">
                        <a href="../php/taskDetail.php?id=<?= $task['id']; ?>" class="task-link">
                            <button class="view-task-button">View Task</button>
                        </a>
                    </div>
                </li>
                <?php $counter++; ?>
                <?php if ($counter % 5 == 0 || $counter == count($incompleteTasks)) : ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    <?php else : ?>
        <p class="no-tasks-message" id="no-tasks-message">Arrr, not a single unfinished task in sight, captain !</p>
    <?php endif; ?>
</div>


<!-- Display Completed Tasks -->
<div class="completed-task-list">
    <h2>Completed Tasks</h2>
    <?php $completedTasks = array_filter($tasks, function($task) { return $task['completed']; }); ?>
    <?php
    // Sort completed tasks by deadline in ascending order
    usort($completedTasks, function($a, $b) {
        return strtotime($a['deadline']) - strtotime($b['deadline']);
    });
    ?>
    <?php if (!empty($completedTasks)) : ?>
        <div class="task-list"> <!-- Use the same class as the incomplete tasks -->
            <?php $counter = 0; ?>
            <?php foreach ($completedTasks as $task) : ?>
                <?php if ($counter % 5 == 0) : ?>
                    <div class="task-row">
                <?php endif; ?>
                <li class="task-item" id="task-item">
                    <h3 class="task-name"><?= $task['name']; ?></h3>
                    <p class="task-description"><?= $task['deadline']; ?></p>
                    <div class="task-buttons">
                        <a href="../php/taskDetail.php?id=<?= $task['id']; ?>" class="task-link">
                            <button class="view-task-button">View Task</button>
                        </a>
                    </div>
                </li>
                <?php $counter++; ?>
                <?php if ($counter % 5 == 0 || $counter == count($completedTasks)) : ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <p class="no-tasks-message" id="no-tasks-message">Avast ye scallywags! Why in the blazes hasn't a single thing been crossed off the list yet? Get to work!</p>
    <?php endif; ?>
</div>
            <?php else : ?>
        <p class="error-message" id="error-message">Arrr, what's this? There be no tasks on this list, it's empty! We have been taken fools mateys!</p>
    <?php endif; ?>

        <!-- Display Delete List and Create Task Buttons -->
        <div class="center-buttons">
            <form method="post">
                <button type="submit" name="delete-list" class="delete-list-button">Delete List</button>
            </form>

            <a href="../php/createNewTask.php?list_id=<?= $listID; ?>" class="create-task-link">
                <button class="create-task-button">Create Task</button>
            </a>
        </div>

    <?php else : ?>
        <p class="error-message" id="error-message">Oops! we didn't seem to get the list of ye.</p>
    <?php endif; ?>
    </div>
</body>
</html>
