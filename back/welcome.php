<?php
if (!isset($_COOKIE['user'])) {
    header("Location: ../index.html");
    exit();
}
$user = htmlspecialchars($_COOKIE['user']);
echo "Привет, $user";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Добро пожаловать</title>
</head>
<body>
    <h2>Привет, <?php echo $user; ?></h2>
    <p>Вы успешно авторизовались.</p>
</body>
</html>
