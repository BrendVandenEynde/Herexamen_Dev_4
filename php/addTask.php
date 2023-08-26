<?php
include_once("../inc/bootstrap.php");

$db = Db::getInstance();
$taskManager = new TaskManager($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $listId = $_POST["list"];
    $name = $_POST["name"];
    $description = $_POST["description"];
    $deadline = $_POST["deadline"];
    $userId = $_SESSION['user_id']; // Add this line

    $list = $taskManager->getListById($listId, $userId);

    if ($list && $taskManager->addTask($listId, $name, $description, $deadline, $userId)) {
        echo "<script>alert('Task added successfully');</script>";
    } else {
        echo "<script>alert('An error occurred while adding the task.');</script>";
    }
}

header("Location: ../php/homePage.php");
exit();
?>
