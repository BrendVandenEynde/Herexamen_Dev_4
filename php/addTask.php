<?php
include_once("../inc/bootstrap.php");
$login = new User();

if (!$login->isLoggedIn()) {
    header("Location: ../login.php");
    exit();
}

$db = Db::getInstance();

// Retrieve user's lists
$userId = $_SESSION['user_id'];
$listsQuery = "SELECT * FROM lists WHERE created_by = :userId";
$listsStmt = $db->prepare($listsQuery);
$listsStmt->bindParam(":userId", $userId);
$listsStmt->execute();
$lists = $listsStmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $listId = $_POST["list"];
    $name = $_POST["name"];
    $description = $_POST["description"];
    $deadline = $_POST["deadline"];

    $query = "INSERT INTO tasks (name, description, deadline, list_id, created_by) VALUES (:name, :description, :deadline, :listId, :userId)";
    
    $stmt = $db->prepare($query);
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":description", $description);
    $stmt->bindParam(":deadline", $deadline);
    $stmt->bindParam(":listId", $listId);
    $stmt->bindParam(":userId", $userId);

    if ($stmt->execute()) {
        echo "<script>alert('Task added successfully');</script>";
    } else {
        echo "<script>alert('An error occurred while adding the task.');</script>";
    }
}

header("Location: ../php/homePage.php");
exit();


?>
