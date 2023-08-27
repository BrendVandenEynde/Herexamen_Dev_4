<?php
// Include necessary files and bootstrap the application
include_once("../inc/bootstrap.php");

// Define a class to manage lists
class ListManager {
    private $db;

    // Constructor: Initialize the database connection
    public function __construct() {
        $this->db = Db::getInstance();
    }

    // Method to create a new list
    public function createNewList($name, $description) {
        // Prepare and execute the INSERT query using a prepared statement
        $query = "INSERT INTO lists (name, description, created_by) VALUES (:name, :description, :userID)";
        $stmt = $this->db->prepare($query);

        // Bind parameters and execute the statement
        $userID = $_SESSION['user_id'];
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);

        // Execute the query and return success status
        if ($stmt->execute()) {
            return true; // List created successfully
        } else {
            return false; // An error occurred while creating the list
        }
    }
}

// Create an instance of ListManager
$listManager = new ListManager();

// Check if the request is a POST and required data is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name'], $_POST['description'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];

    // XSS protection (escape HTML entities)
    $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
    $description = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');

    // Call the createNewList method and handle the result
    if ($listManager->createNewList($name, $description)) {
        header("Location: ../php/homePage.php"); // Redirect to homePage.php on success
        exit();
    } else {
        echo "Error creating list."; // Display an error message
    }
}
?>

<script>
    // Add an event listener to the form submission
    document.getElementById("create-list-form").addEventListener("submit", function(event) {
        event.preventDefault();
        var form = event.target;

        // Use fetch API to submit the form data
        fetch(form.action, {
            method: form.method,
            body: new FormData(form)
        })
        .then(response => response.text())
        .then(data => {
            if (data === "success") {
                alert("List created successfully!");
                window.location.href = "../php/homePage.php"; // Redirect to homePage.php on success
            } else {
                alert("Error creating list.");
            }
        })
        .catch(error => {
            console.error("An error occurred:", error);
            alert("An error occurred.");
        });
    });
</script>
