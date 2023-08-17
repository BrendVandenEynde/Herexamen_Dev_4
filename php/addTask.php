<?php
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "todolist";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task1 = $_POST["task1"];
    $task2 = $_POST["task2"];

    $sql = "INSERT INTO tasks (task) VALUES ('$task1'), ('$task2')";
    
    if ($conn->multi_query($sql) === TRUE) {
        echo "Tasks added successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
