<?php

class User
{
    private $db;
    private $error;

    public function __construct()
    {
        session_start(); // Start the session

        $this->db = Db::getInstance();
    }

    public function validateLogin($email, $hashedPassword)
    {
        $query = "SELECT id, email, hashed_password FROM users WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($hashedPassword, $user['hashed_password'])) {
            return true;
        }

        return false;
    }

    public function doLogin()
    {
        $query = "SELECT id FROM users WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $_POST['email']); // Assuming you need to access the email entered in the login form
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION['user_id'] = $user['id']; // Set user ID in session
        }
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

    public function setError($errorMessage)
    {
        $this->error = $errorMessage;
    }

    public function getError()
    {
        return $this->error;
    }
}
