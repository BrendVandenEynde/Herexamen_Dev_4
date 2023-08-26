<?php
class TaskManager {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function addTask($listId, $name, $description, $deadline, $userId) {
        $query = "INSERT INTO tasks (name, description, deadline, list_id, created_by) VALUES (:name, :description, :deadline, :listId, :userId)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":deadline", $deadline);
        $stmt->bindParam(":listId", $listId);
        $stmt->bindParam(":userId", $userId);

        return $stmt->execute();
    }

    public function getListById($listId, $userId) { // Add $userId parameter
        $query = "SELECT * FROM lists WHERE id = :listId AND created_by = :userId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":listId", $listId);
        $stmt->bindParam(":userId", $userId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserLists($userId) {
        $query = "SELECT * FROM lists WHERE created_by = :userId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":userId", $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
