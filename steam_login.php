<?php
require 'vendor/autoload.php'; // Подключаем библиотеку OpenID

use LightOpenID;

session_start();

$openid = new LightOpenID('тут домен'); // Укажите ваш домен

if (!$openid->mode) {
    $openid->identity = 'https://steamcommunity.com/openid';
    header('Location: ' . $openid->authUrl());
} elseif ($openid->mode == 'cancel') {
    echo 'Отменено пользователем.';
} else {
    if ($openid->validate()) {
        $steam_id = $openid->getIdentity();
        
        // Подключение к базе данных
        $conn = new mysqli('localhost', 'username', 'password', 'database');

        if ($conn->connect_error) {
            die("Ошибка подключения: " . $conn->connect_error);
        }

        // Проверка, существует ли пользователь
        $stmt = $conn->prepare("SELECT * FROM users WHERE steam_id = ?");
        $stmt->bind_param("s", $steam_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            // Если пользователь не существует, добавляем его
            $stmt = $conn->prepare("INSERT INTO users (steam_id) VALUES (?)");
            $stmt->bind_param("s", $steam_id);
            $stmt->execute();
            echo "Пользователь зарегистрирован!";
        } else {
            echo "Пользователь уже зарегистрирован!";
        }

        $_SESSION['steam_id'] = $steam_id; // Сохраняем ID в сессии
        $stmt->close();
        $conn->close();

        header('Location: welcome.php'); // Перенаправление на страницу приветствия
    } else {
        echo 'Ошибка аутентификации.';
    }
}
?>