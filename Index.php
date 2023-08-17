<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="./images/DefFaviconPortPixel.svg">
    <link rel="stylesheet" href="./css/style.css">
    <title>Login</title>
</head>
<body class="login-body">
  <h1 class="login-header">Port Pixel To-Do List</h1>
  <div class="login-container">
    <h2>Avast, Matey! Secure Your Voyage:<br>Log In to Set Sail!</h2>
    <form method="POST" action="login.php">
      <div class="login-form-group">
        <label class="login-label" for="username">Shipmate, state yer name</label>
        <input class="login-input" type="text" id="username" name="username" required placeholder="Sailor's Username">
      </div>
      <div class="login-form-group">
        <label class="login-label" for="password">What's the secret code?</label>
        <input class="login-input" type="password" id="password" name="password" required placeholder="Enter Yer Password">
      </div>
      <div class="login-form-group">
        <input class="login-submit" type="submit" value="Log in">
      </div>
    </form>
  </div>
</body>
</html>
