<?php
include_once("../inc/bootstrap.php");

// Create a new User instance to manage login
$login = new User();

// Redirect to login page if not logged in
if (!$login->isLoggedIn()) {
    header("Location: ../login.php");
    exit();
}

// Get a database instance
$db = Db::getInstance();

// Get the task ID from the URL parameter
$taskID = isset($_GET['id']) ? $_GET['id'] : null;

if ($taskID === null) {
    // Redirect or display an error message because task ID is not provided
    exit();
}

// Instantiate the TaskManager class with the database instance
$taskManager = new TaskManager($db);

// Query for the task details based on the task ID
$task = $taskManager->getTaskById($taskID);

// Handle delete task
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    if ($taskManager->deleteTask($taskID)) {
        echo "<script>alert('Task deleted successfully.'); window.location.href = 'homePage.php';</script>";
        exit();
    } else {
        echo "<script>alert('An error occurred while deleting the task.');</script>";
    }
}

// Check if the task is completed
$taskCompleted = $taskManager->isTaskCompleted($task);

// Handle complete task
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['complete']) && !$taskCompleted) {
    if ($taskManager->completeTask($taskID)) {
        echo "<script>alert('Task completed successfully.'); window.location.href = 'homePage.php';</script>";
        exit();
    } else {
        echo "<script>alert('An error occurred while completing the task.');</script>";
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
    <title><?= $task['name']; ?> - Detailed Page</title>
</head>

<body class="detail-page">
    <?php include '../inc/nav.inc.php'; ?>

    <div class="detail-list-name">
        <h1><?= $task['name']; ?></h1>
    </div>

    <div class="detail-item-info">
        <p>Description: <?= htmlspecialchars($task['description'], ENT_QUOTES, 'UTF-8'); ?></p>
        <p>Deadline: <?= htmlspecialchars($task['deadline'], ENT_QUOTES, 'UTF-8'); ?></p>
    </div>

    <div class="buttons">
        <!-- Complete Task Button -->
        <?php if (!$taskCompleted) : ?>
            <form method="post">
                <button type="submit" name="complete">Complete Task</button>
            </form>
        <?php endif; ?>

        <!-- Delete Task Button -->
        <form method="post">
            <button type="submit" name="delete">Delete Task</button>
        </form>
    </div>

</body>

</html>