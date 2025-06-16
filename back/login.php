<?php
require 'db.php';
$username = $_POST['username'];
$password = $_POST['password'];
$result = $db->query("SELECT * FROM users WHERE username = '$username' AND password = '$password'");
if ($result->fetch()) {
    setcookie("user", $username, time() + 3600);
    header("Location: welcome.php");
} else {
    echo "Invalid credentials";
}
?>
