<?php
require 'db.php';
$username = $_POST['username'];
$password = $_POST['password'];
$db->exec("INSERT INTO users (username, password) VALUES ('$username', '$password')");
setcookie("user", $username, time() + 3600); // Cookie реализовано здесь
header("Location: welcome.php");
?>
