<?php

session_start(); // Start the session if it's not already started

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to Index.php after logout
header('Location: ../Index.php');
exit();
?>
