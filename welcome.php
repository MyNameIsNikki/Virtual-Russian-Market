<?php
session_start();

if (!isset($_SESSION['steam_id'])) {
    header('Location: steam_login.php'); // Перенаправление на страницу входа
    exit();
}

echo "Добро пожаловать, пользователь с ID: " . htmlspecialchars($_SESSION['steam_id']);
?>
<a href="logout.php">Выйти</a>