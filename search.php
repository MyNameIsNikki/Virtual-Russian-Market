// search.php
<?php
$conn = new mysqli('localhost', 'username', 'password', 'database');

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

$query = $_GET['q'];
$sql = "SELECT * FROM items WHERE name LIKE ?";
$stmt = $conn->prepare($sql);
$searchTerm = "%" . $query . "%";
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    echo "<div>" . htmlspecialchars($row['name']) . " - " . htmlspecialchars($row['price']) . " руб.</div>";
}

$stmt->close();
$conn->close();
?>