<?php
class TaskManager {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function addTask($listId, $name, $description, $deadline, $userId) {
        // Sanitize user input
        $name = $this->sanitizeInput($name);
        $description = $this->sanitizeInput($description);
        $deadline = $this->sanitizeInput($deadline);

        // Prepare the INSERT query using a prepared statement
        $query = "INSERT INTO tasks (name, description, deadline, list_id, created_by) VALUES (:name, :description, :deadline, :listId, :userId)";
        $stmt = $this->db->prepare($query);

        // Bind parameters to the prepared statement
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":deadline", $deadline);
        $stmt->bindParam(":listId", $listId);
        $stmt->bindParam(":userId", $userId);

        // Execute the query and return success status
        return $stmt->execute();
    }

    public function getListById($listId, $userId) {
        // Prepare the SELECT query using a prepared statement
        $query = "SELECT * FROM lists WHERE id = :listId AND created_by = :userId";
        $stmt = $this->db->prepare($query);

        // Bind parameters to the prepared statement
        $stmt->bindParam(":listId", $listId);
        $stmt->bindParam(":userId", $userId);

        // Execute the query and return the result
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserLists($userId) {
        // Prepare the SELECT query using a prepared statement
        $query = "SELECT * FROM lists WHERE created_by = :userId";
        $stmt = $this->db->prepare($query);

        // Bind parameter to the prepared statement
        $stmt->bindParam(":userId", $userId);

        // Execute the query and return the results
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Sanitize user input to prevent XSS attacks
    private function sanitizeInput($input) {
        return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    }
}
?>
