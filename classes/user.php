<?php

class User {
    private $db;
    private $error;
    private $username;

    public function __construct() {
        session_start();
        $this->db = Db::getInstance();
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getError() {
        return $this->error;
    }

    public function register() {
        if (empty($this->email) || empty($this->password) || empty($this->username)) {
            $this->error = "Please enter email, password, and username.";
            return;
        }

        $hashedPassword = password_hash($this->password, PASSWORD_BCRYPT, ['cost' => 12]);

        $query = "INSERT INTO user (email, password, username) VALUES (:email, :password, :username)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':username', $this->username);

        if ($stmt->execute()) {
            $_SESSION['user_id'] = $this->db->lastInsertId();
            header("Location: ../index.php"); // Redirect to dashboard on successful registration
            exit();
        } else {
            $this->error = "An error occurred while registering.";
        }
    }
    
    public function doLogin() {
        // Validate user input
        if (empty($this->email) || empty($this->password)) {
            $this->error = "Please enter both email and password.";
            return;
        }
    
        // Perform database check
        $query = "SELECT id, password FROM user WHERE email = :email"; // Use correct table name 'user'
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($user && password_verify($this->password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: ./pages/homePage.php"); // Redirect to dashboard on successful login
            exit();
        } else {
            $this->error = "Invalid email or password.";
        }
    }

    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    public function logout() {
        session_destroy();
        header("Location: ../Index.php"); // Corrected path
        exit();
    }
}
?>
