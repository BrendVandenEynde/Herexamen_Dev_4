<?php
include_once("../classes/User.php");
include_once("../classes/Db.php");

$login = new User();

if (!$login->isLoggedIn()) {
    header("Location: ../login.php");
    exit();
}

$db = Db::getInstance();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $description = $_POST["description"];
    $deadline = $_POST["deadline"];
    $userId = $_SESSION['user_id'];

    $query = "INSERT INTO list (name, description, deadline, created_by) VALUES (:name, :description, :deadline, :userId)";
    
    // Debugging: Echo the query for verification
    echo "Query: $query";

    $stmt = $db->prepare($query);
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":description", $description);
    $stmt->bindParam(":deadline", $deadline);
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

