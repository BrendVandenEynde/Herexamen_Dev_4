<?php
include_once("../classes/User.php");
include_once("../classes/Db.php");

$login = new User();

if (!$login->isLoggedIn()) {
    header("Location: ../login.php"); // Redirect to login if not logged in
    exit();
}

$db = Db::getInstance();
$userID = $_SESSION['user_id'];

// Retrieve the username from the database based on the user's ID
$usernameQuery = "SELECT username FROM user WHERE id = :user_id";
$usernameStmt = $db->prepare($usernameQuery);
$usernameStmt->bindParam(':user_id', $userID);
$usernameStmt->execute();
$usernameResult = $usernameStmt->fetch(PDO::FETCH_ASSOC);
$username = $usernameResult['username'];

// Query for incomplete tasks
$incompleteQuery = "SELECT * FROM list WHERE created_by = :user_id AND incomplete = 1 ORDER BY deadline ASC";
$incompleteStmt = $db->prepare($incompleteQuery);
$incompleteStmt->bindParam(':user_id', $userID);
$incompleteStmt->execute();
$incompleteTasks = $incompleteStmt->fetchAll(PDO::FETCH_ASSOC);

// Query for completed tasks
$completedQuery = "SELECT * FROM list WHERE created_by = :user_id AND completed = 1 ORDER BY deadline DESC";
$completedStmt = $db->prepare($completedQuery);
$completedStmt->bindParam(':user_id', $userID);
$completedStmt->execute();
$completedTasks = $completedStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/svg+xml" href="../images/DefFaviconPortPixel.svg">
  <link rel="stylesheet" href="../css/style.css">
  <title>Home Page</title>
</head>
<body>
<?php include '../classes/navbar.php'; ?>

<div class="container">
    <h1>Ahoy, <?= $username; ?>! Find your tasks down here!</h1>

    <h2>Incomplete Tasks</h2>
    <ul class="item-list">
        <?php foreach ($incompleteTasks as $task) : ?>
            <li class="item-card">
                <h3><?= $task['name']; ?></h3>
                <p>Deadline: <?= $task['deadline']; ?></p>
            </li>
        <?php endforeach; ?>
    </ul>

    <h2>Completed Tasks</h2>
    <ul class="item-list">
        <?php foreach ($completedTasks as $task) : ?>
            <li class="item-card">
                <h3><?= $task['name']; ?></h3>
                <p>Deadline: <?= $task['deadline']; ?></p>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
</body>
</html>
