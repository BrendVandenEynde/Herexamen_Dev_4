<?php
// Include necessary files and bootstrap the application
include_once("./inc/bootstrap.php");

// Instantiate the User class for login handling
$login = new User();

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Set the entered email and password using setters
    $login->setEmail($_POST["email"]);
    $login->setPassword($_POST["password"]);

    // Call the doLogin method to handle login logic
    if ($login->doLogin()) {
        // Redirect to homePage.php on successful login
        header("Location: ../Herexamen_Dev_4/php/homePage.php");
        exit();
    } else {
        $loginError = "Invalid email or password. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="../images/DefFaviconPortPixel.svg">
    <link rel="stylesheet" href="./css/style.css">
    <title>Login</title>
</head>
<body class="login-body">
    <h1 class="login-header">Port Pixel To-Do List</h1>
    <div class="login-container">
        <h2>Avast, Matey! Secure Your Voyage:<br>Log In to Set Sail!</h2>
        <form method="POST" action="">
            <?php if (isset($loginError)) : ?> <!-- Display login error message -->
                <p class="login-error"><?php echo $loginError; ?></p>
            <?php endif; ?>
            <div class="login-form-group">
                <label class="login-label" for="email">Shipmate, state yer name</label>
                <input class="login-input" type="email" id="email" name="email" required placeholder="Sailor's Email">
            </div>
            <div class="login-form-group">
                <label class="login-label" for="password">What's the secret code?</label>
                <input class="login-input" type="password" id="password" name="password" required placeholder="Enter Yer Password">
            </div>
            <div class="login-form-group">
                <input class="login-submit" type="submit" value="Log in">
            </div>
        </form>
        <p class="register-link">Don't have an account? <a href="./php/register.php">Register here</a></p> 
    </div>
</body>
</html>
