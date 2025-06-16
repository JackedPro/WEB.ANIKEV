<?php
session_start();

// Простая маршрутизация
$page = $_GET['page'] ?? 'home';

if ($page === 'register' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // регистрация
    $u = $_POST['username'];
    $p = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $db = new PDO('sqlite:users.db');
    $db->exec("CREATE TABLE IF NOT EXISTS users(username TEXT PRIMARY KEY, pass TEXT)");
    $stmt = $db->prepare("INSERT INTO users VALUES (?, ?)");
    $stmt->execute([$u, $p]);
    header('Location: ?page=login');
    exit;
}

if ($page === 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = $_POST['username'];
    $p = $_POST['password'];
    $db = new PDO('sqlite:users.db');
    $stmt = $db->prepare("SELECT pass FROM users WHERE username=?");
    $stmt->execute([$u]);
    if ($hash = $stmt->fetchColumn()) {
        if (password_verify($p, $hash)) {
            $_SESSION['user'] = $u;
            header('Location: ?page=welcome');
            exit;
        }
    }
    $error = "Неверно";
}

function renderForm($action, $button) {
    global $error;
    echo '<h2>' . ucfirst($button) . '</h2>';
    if ($error) echo "<p style='color:red;'>$error</p>";
    echo "<form method='post' action='?page=$action'>
        <input name='username' placeholder='User'><br>
        <input name='password' type='password' placeholder='Pass'><br>
        <button>$button</button>
    </form>";
}

// Маршрутизация страниц
if ($page === 'register') {
    renderForm('register', 'Register');
} elseif ($page === 'login') {
    renderForm('login', 'Login');
} elseif ($page === 'welcome') {
    if (!isset($_SESSION['user'])) {
        header('Location: ?page=login');
        exit;
    }
    $u = htmlspecialchars($_SESSION['user']);
    echo "<p>Привет, $u!</p>";
    echo '<a href="?page=logout">Logout</a>';
} elseif ($page === 'logout') {
    session_destroy();
    header('Location: ?page=login');
    exit;
} else {
    echo '<a href="?page=register">Register</a> | <a href="?page=login">Login</a>';
}
