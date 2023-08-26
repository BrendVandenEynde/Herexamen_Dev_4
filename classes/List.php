<?php
include_once("../inc/bootstrap.php");

class ListManager {
    private $db;

    public function __construct() {
        $this->db = Db::getInstance();
    }

    public function createNewList($name, $description) {
        // Prepare and execute the INSERT query using a prepared statement
        $query = "INSERT INTO lists (name, description, created_by) VALUES (:name, :description, :userID)";
        $stmt = $this->db->prepare($query);

        // Bind parameters and execute the statement
        $userID = $_SESSION['user_id'];
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true; // List created successfully
        } else {
            return false; // An error occurred while creating the list
        }
    }
}

$listManager = new ListManager();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name'], $_POST['description'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];

    if ($listManager->createNewList($name, $description)) {
        header("Location: ../php/homePage.php"); // Redirect to homePage.php on success
        exit();
    } else {
        echo "Error creating list."; // Display an error message
    }
}
?>

<script>
    document.getElementById("create-list-form").addEventListener("submit", function(event) {
        event.preventDefault();
        var form = event.target;

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
