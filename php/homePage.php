<?php
include_once("../classes/functions.php");

$login = new User();

if (!$login->isLoggedIn()) {
    header("Location: ../login.php"); // Redirect to login if not logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/svg+xml" href="../images/DefFaviconPortPixel.svg">
  <link rel="stylesheet" href="../css/style.css">
  <title>Home Page</title>
</head>
<body>
<?php include '../classes/navbar.php'; ?>

  <div class="container">
    <h1>Ahoy, Sailor! Find your tasks down here!</h1>

    <h2>Item List</h2>
    <ul class="item-list">
      <li class="item-card" onclick="location.href='../php/detail.php'">
        <h3>Item 1</h3>
        <p>Description: Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        <p>Price: $19.99</p>
      </li>
      <li class="item-card" onclick="location.href='../php/detail.php'">
        <h3>Item 2</h3>
        <p>Description: Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        <p>Price: $24.99</p>
      </li>
      <li class="item-card" onclick="location.href='../php/detail.php'">
        <h3>Item 3</h3>
        <p>Description: Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        <p>Price: $29.99</p>
      </li>
    </ul>
  </div>
</body>
</html>
