<?php
session_start();
if (!isset($_SESSION['steam_id'])) {
    header('Location: steam_login.php'); // Перенаправление на страницу входа
    exit();
}

// Проверяем, что запрос был отправлен методом POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Получаем данные из формы
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // Подключение к базе данных
    $conn = new mysqli('localhost', 'username', 'password', 'database');

    // Проверка подключения
    if ($conn->connect_error) {
        die("Ошибка подключения: " . $conn->connect_error);
    }

    // Подготовка и выполнение запроса на добавление товара
    $stmt = $conn->prepare("INSERT INTO items (name, price, description) VALUES (?, ?, ?)");
    $stmt->bind_param("sds", $name, $price, $description);

    if ($stmt->execute()) {
        echo "Товар успешно добавлен!";
    } else {
        echo "Ошибка: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавить товар</title>
</head>
<body>
    <h1>Добавить товар</h1>
    <form method="POST" action="add_item.php">
        <label for="name">Название:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="price">Цена:</label>
        <input type="number" id="price" name="price" required><br>

        <label for="description">Описание:</label>
        <textarea id="description" name="description" required></textarea><br>

        <input type="submit" value="Добавить товар">
    </form>
    <a href="welcome.php">Назад</a>
</body>
</html>