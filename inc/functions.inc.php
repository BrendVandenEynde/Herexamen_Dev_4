    <?php
    class User {
        private $email;
        private $password;
        private $error;

        public function setEmail($email) {
            $this->email = $email;
        }

        public function setPassword($password) {
            $this->password = $password;
        }

        public function getError() {
            return $this->error;
        }

        public function doLogin() {
            // Validate user input
            if (empty($this->email) || empty($this->password)) {
                $this->error = "Please enter both email and password.";
                return;
            }

            // Perform database check (replace this with your actual database logic)
            if ($this->email === "user@example.com" && $this->password === "password123") {
                $_SESSION['user'] = $this->email;
                header("Location: dashboard.php"); // Redirect to dashboard on successful login
                exit();
            } else {
                $this->error = "Invalid email or password.";
            }
        }

        public function isLoggedIn() {
            return isset($_SESSION['user']);
        }

        public function logout() {
            session_destroy();
            header("Location: ./index.php");
            exit();
        }
    }
    ?>
