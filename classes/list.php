<?php
include_once("../classes/User.php");
include_once("../classes/Db.php");

$login = new User();

if (!$login->isLoggedIn()) {
    header("Location: ../login.php");
    exit();
}

$db = Db::getInstance();

$query = "SELECT * FROM list";
$result = $db->query($query);

if (!$result) {
    echo "Error fetching data from database: " . $db->error;
} else {

}
?>
