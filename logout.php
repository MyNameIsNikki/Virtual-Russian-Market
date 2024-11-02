<?php
session_start();
session_destroy(); // Удаляем сессию
header('Location: steam_login.php'); // Перенаправление на страницу входа
?>