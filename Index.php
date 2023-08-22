<?php
session_start();

include_once("../classes/functions.php");
include_once("../classes/user.php");

$login = new User(); // Instantiate the User class

$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Sanitize user input to prevent SQL injection
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        // Check if the password meets strong password criteria
        if (validatePasswordStrength($password)) {
            // Hash the password using bcrypt with cost factor 12
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

            if ($login->validateLogin($email, $hashedPassword)) {
                $login->doLogin();
                $_SESSION['message'] = "Login successful!";
                header("Location: ../php/homePage.php"); // Redirect to the home page
                exit;
            } else {
                $error = "Invalid email or password.";
            }
        } else {
            $error = "Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one digit, and one special character.";
        }
    } else {
        $error = "Please provide both email and password.";
    }
}

if ($login->isLoggedIn()) {
    header("Location: ../php/homePage.php"); // Redirect if already logged in
    exit();
}

// Function to validate password strength
function validatePasswordStrength($password) {
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);

    return $uppercase && $lowercase && $number && $specialChars && strlen($password) >= 8;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
  <h1>Login</h1>
  <?php if ($error) : ?>
    <p><?php echo $error; ?></p>
  <?php endif; ?>
  <form method="POST" action="login.php">
    <div>
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required>
    </div>
    <div>
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>
    </div>
    <div>
      <input type="submit" value="Log in">
    </div>
  </form>
</body>
</html>
