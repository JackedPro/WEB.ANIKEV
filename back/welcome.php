<?php
if (!isset($_COOKIE['user'])) {
    header("Location: ../index.html");
    exit();
}
$user = htmlspecialchars($_COOKIE['user']);
echo "Привет, $user";
?>
