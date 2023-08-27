<?php
// Include necessary files and bootstrap the application
include_once("../inc/bootstrap.php");
include_once("../classes/List.php"); // Include the ListManager class

// Create a new User instance to manage login
$login = new User();

// Redirect to login page if not logged in
if (!$login->isLoggedIn()) {
    header("Location: ../login.php");
    exit();
}

// Get a database instance
$db = Db::getInstance();

// Get the user's ID from the session
$userID = $_SESSION['user_id'];

$user = new User();
$username = $user->getUsername($userID);

$listManager = new ListManager($db);
$userLists = $listManager->getAllLists($userID);
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
    <?php include '../inc/nav.inc.php'; ?>

    <div class="container">
        <h1>Ahoy, <?= $username; ?>! Find your to-do lists down here!</h1>

      <!-- User's Lists Section -->
      <?php if (count($userLists) > 0) : ?>
    <h2>Your Bountiful Lists</h2>
    <div class="lists-container">
        <?php $counter = 0; ?>
        <div class="lists-row">
            <?php foreach ($userLists as $list) : ?>
                <div class="item-card">
                    <h3 class="list-name"><?= htmlspecialchars($list['name']); ?></h3>
                    <?php if (!empty($list['description'])) : ?>
                        <p><?= htmlspecialchars($list['description']); ?></p>
                    <?php endif; ?>
                    <div class="center-text">
                        <a href="../php/listDetail.php?id=<?= $list['id'];?>" class="item-link">
                            <button class="view-list-button">View List</button>
                        </a>
                    </div>
                </div>
                <?php $counter++; ?>
                <?php if ($counter % 5 == 0) : ?>
                    </div><div class="lists-row">
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
        <?php else : ?>
            <p class="no-lists-message">Arrr, there be no lists here. Seems like we have nothing to do.</p>
        <?php endif; ?>
    </div>
</body>
</html>
