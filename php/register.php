<?php
include_once("../inc/bootstrap.php");

$error = '';

$login = new User(); // Instantiate the User class

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['logout'])) {
    $login->logout();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $register = new User();

    $register->setEmail($_POST['email']);
    $register->setPassword($_POST['password']);
    $register->setUsername($_POST['username']);

    $register->register();

    if ($register->getError()) {
        $error = $register->getError();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="./images/DefFaviconPortPixel.svg">
    <link rel="stylesheet" href="../css/style.css">
    <title>Register</title>
</head>
<body class="register-body">
  <h1 class="register-header">Port Pixel To-Do List</h1>
  <div class="register-container">
    <h2>Join the Crew: Register an Account</h2>
    <form method="POST" action="register.php">
      <?php if ($error) : ?>
        <p class="register-error"><?php echo $error; ?></p>
      <?php endif; ?>
      <div class="register-form-group">
        <label class="register-label" for="username">Choose yer username</label>
        <input class="register-input" type="text" id="username" name="username" required placeholder="Username">
      </div>
      <div class="register-form-group">
        <label class="register-label" for="email">Shipmate, state yer email</label>
        <input class="register-input" type="email" id="email" name="email" required placeholder="Email">
      </div>
      <div class="register-form-group">
        <label class="register-label" for="password">Set yer secret code</label>
        <input class="register-input" type="password" id="password" name="password" required placeholder="Password">
      </div>
      <div class="register-form-group">
        <label class="register-label" for="confirm_password">Confirm yer secret code</label>
        <input class="register-input" type="password" id="confirm_password" name="confirm_password" required placeholder="Confirm Password">
      </div>
      <div class="register-form-group">
        <input class="register-submit" type="submit" value="Register">
        <p>Already have an account? <a href="../index.php">Log in here</a></p> <!-- Link to go back to the login page -->
      </div>
    </form>
  </div>
</body>
</html>
      