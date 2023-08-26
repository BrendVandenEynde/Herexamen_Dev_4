<?php
include_once("./inc/bootstrap.php");

$login = new User(); // Instantiate the User class

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $login->setEmail($_POST["email"]);
    $login->setPassword($_POST["password"]);
    $login->doLogin(); // Handle login logic
}

if ($login->isLoggedIn()) {
    header("Location: ../Herexamen_Dev_4/php/homePage.php"); // Adjusted path
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="../images/DefFaviconPortPixel.svg"> <!-- Adjusted path -->
    <link rel="stylesheet" href="./css/style.css"> <!-- Adjusted path -->
    <title>Login</title>
</head>
<body class="login-body">
  <h1 class="login-header">Port Pixel To-Do List</h1>
  <div class="login-container">
    <h2>Avast, Matey! Secure Your Voyage:<br>Log In to Set Sail!</h2>
    <form method="POST" action="">
      <?php if ($error = $login->getError()) : ?> <!-- Display error from the User class -->
        <p class="login-error"><?php echo $error; ?></p>
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
    <p class="register-link">Don't have an account? <a href="./php/register.php">Register here</a></p> <!-- Adjusted path -->
  </div>
</body>
</html>
