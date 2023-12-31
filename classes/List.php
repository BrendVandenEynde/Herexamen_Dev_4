<?php
// Include necessary files and bootstrap the application
include_once("../inc/bootstrap.php");

// Define a class to manage lists
class ListManager
{
    private $db;

    // Constructor: Initialize the database connection
    public function __construct($db)
    {
        $this->db = $db;
    }

    // Method to create a new list
    public function createNewList($name, $description, $userID)
    {
        $query = "INSERT INTO lists (name, description, created_by) VALUES (:name, :description, :userID)";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);

        return $stmt->execute(); // Return execution result
    }

    public function getList($listID, $userID)
    {
        $listQuery = "SELECT * FROM lists WHERE id = :list_id AND created_by = :user_id";
        $listStmt = $this->db->prepare($listQuery);
        $listStmt->bindParam(':list_id', $listID);
        $listStmt->bindParam(':user_id', $userID);
        $listStmt->execute();
        return $listStmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getTasks($listID)
    {
        $tasksQuery = "SELECT * FROM tasks WHERE list_id = :list_id";
        $tasksStmt = $this->db->prepare($tasksQuery);
        $tasksStmt->bindParam(':list_id', $listID);
        $tasksStmt->execute();
        return $tasksStmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteList($listID)
    {
        $this->db->beginTransaction();
        try {
            $deleteTasksQuery = "DELETE FROM tasks WHERE list_id = :list_id";
            $deleteTasksStmt = $this->db->prepare($deleteTasksQuery);
            $deleteTasksStmt->bindParam(':list_id', $listID);
            $deleteTasksStmt->execute();

            $deleteListQuery = "DELETE FROM lists WHERE id = :list_id";
            $deleteListStmt = $this->db->prepare($deleteListQuery);
            $deleteListStmt->bindParam(':list_id', $listID);
            $deleteListStmt->execute();

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollback();
            return false;
        }
    }

    public function getAllLists($user_id)
    {
        $query = "SELECT * FROM lists WHERE created_by = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}


// Create an instance of ListManager
$listManager = new ListManager(Db::getInstance());

// Check if the request is a POST and required data is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name'], $_POST['description'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];

    // XSS protection (escape HTML entities)
    $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
    $description = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');

    $userID = $_SESSION['user_id'];

    // Call the createList method and handle the result
    if ($listManager->createNewList($name, $description, $userID)) {
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