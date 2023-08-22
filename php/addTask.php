<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "portpixel"; // Make sure this is the correct database name

conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task1 = $_POST["task1"];
    $task2 = $_POST["task2"];

    // Using prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO list (name, description) VALUES (?, ?)");
    $stmt->bind_param("ss", $task1, $task2);

    if ($stmt->execute()) {
        echo "List created successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>