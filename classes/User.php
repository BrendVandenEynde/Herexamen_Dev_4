<?php
class User {
    private $db;
    private $error;
    private $username;

    public function __construct() {
        $this->db = Db::getInstance(); // Get a database instance
    }

    // Set user's email
    public function setEmail($email) {
        $this->email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
    }

    // Set user's password
    public function setPassword($password) {
        $this->password = $password;
    }

    // Set user's username, ensure no XSS vulnerabilities
    public function setUsername($username) {
        $this->username = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
    }

    // Get error message
    public function getError() {
        return $this->error;
    }

    // User registration
    public function register() {
        if (empty($this->email) || empty($this->password) || empty($this->username)) {
            $this->error = "Please enter email, password, and username.";
            return;
        }

        // Hash the password for security
        $hashedPassword = password_hash($this->password, PASSWORD_BCRYPT, ['cost' => 12]);

        // Insert user data into the database using prepared statements
        $query = "INSERT INTO user (email, password, username) VALUES (:email, :password, :username)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':username', $this->username);

        if ($stmt->execute()) {
            $_SESSION['user_id'] = $this->db->lastInsertId();
            header("Location: ../index.php"); // Redirect to index.php on successful registration
            exit();
        } else {
            $this->error = "An error occurred while registering.";
        }
    }

    // User login
    public function doLogin() {
        // Validate user input
        if (empty($this->email) || empty($this->password)) {
            $this->error = "Please enter both email and password.";
            return;
        }

        // Perform database check using prepared statements
        $query = "SELECT id, password FROM user WHERE email = :email"; 
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check password and set session on successful login
        if ($user && password_verify($this->password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: ./php/homePage.php"); // Redirect to dashboard on successful login
            exit();
        } else {
            $this->error = "Invalid email or password.";
        }
    }

    // Check if a user is logged in
    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    // User logout
    public function logout() {
        session_destroy(); // Destroy the session
        header("Location: ../index.php"); 
        exit();
    }
}
?>
