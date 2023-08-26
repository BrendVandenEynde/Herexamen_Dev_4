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

// Query for the task details based on the task ID
$taskQuery = "SELECT * FROM tasks WHERE id = :task_id"; // Use "tasks" table here
$taskStmt = $db->prepare($taskQuery);
$taskStmt->bindParam(':task_id', $taskID);
$taskStmt->execute();
$task = $taskStmt->fetch(PDO::FETCH_ASSOC);

// Handle delete task
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $deleteQuery = "DELETE FROM tasks WHERE id = :task_id"; // Change "lists" to "tasks"
    $deleteStmt = $db->prepare($deleteQuery);
    $deleteStmt->bindParam(':task_id', $taskID);

    if ($deleteStmt->execute()) {
        echo "<script>alert('Task deleted successfully.'); window.location.href = 'homePage.php';</script>";
        exit();
    } else {
        echo "<script>alert('An error occurred while deleting the task.');</script>";
    }
}

// Check if the task is completed
$taskCompleted = $task['completed'] == 1;

// Handle complete task
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['complete']) && !$taskCompleted) {
    $completeQuery = "UPDATE tasks SET completed = 1 WHERE id = :task_id"; // Change "lists" to "tasks"
    $completeStmt = $db->prepare($completeQuery);
    $completeStmt->bindParam(':task_id', $taskID);
    
    if ($completeStmt->execute()) {
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
    <p>Description: <?= $task['description']; ?></p>
    <p>Deadline: <?= $task['deadline']; ?></p>
</div>

<div class="buttons">
    <!-- Complete Task Button -->
    <?php if (!$taskCompleted): ?>
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
