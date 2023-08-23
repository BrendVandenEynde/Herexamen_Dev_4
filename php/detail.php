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

</body>
</html>