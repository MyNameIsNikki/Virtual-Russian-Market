<?php
//ключ API Steam
$apiKey = 'КЛЮЧ_API';
$appId = '000'; // Заменить надо на ID предложения (написал число рандомное)!
$itemDefId = '4111'; // Заменить на ID предмета (тоже рандомное число написал)!

// URL для запроса
$url = "https://api.steampowered.com/IInventoryService/GetPriceSheet/v1/?key={$apiKey}&appid={$appId}";

// Получаем данные с API
$response = file_get_contents($url);
$data = json_decode($response, true);

// Проверяем успешность запроса
if (isset($data['response']['success']) && $data['response']['success']) {
    // Извлекаем цену
    $price = $data['response']['price_sheet'][$itemDefId]['price']; // Замените на правильный путь к цене
    echo json_encode(['price' => $price]);
} else {
    echo json_encode(['error' => 'Не удалось получить данные']);
}
?>