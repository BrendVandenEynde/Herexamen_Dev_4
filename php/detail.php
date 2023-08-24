<?php
include_once("../classes/User.php");
include_once("../classes/Db.php");

$login = new User();

if (!$login->isLoggedIn()) {
    header("Location: ../login.php"); // Redirect to login if not logged in
    exit();
}

$db = Db::getInstance();

// Get the task ID from the URL parameter
$taskID = $_GET['id'];

// Query for the task details based on the task ID
$taskQuery = "SELECT * FROM list WHERE id = :task_id";
$taskStmt = $db->prepare($taskQuery);
$taskStmt->bindParam(':task_id', $taskID);
$taskStmt->execute();
$task = $taskStmt->fetch(PDO::FETCH_ASSOC);

// Handle delete task
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $deleteQuery = "DELETE FROM list WHERE id = :task_id";
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
  $completeQuery = "UPDATE list SET incomplete = 0, completed = 1 WHERE id = :task_id";
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
<?php include '../classes/navbar.php'; ?>

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
