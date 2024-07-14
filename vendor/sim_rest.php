<?php
require 'connect.php';

$business_id = isset($_POST['business_id']) ? $_POST['business_id'] : null;

$response = [];
 
if ($business_id !== null) {
    exec("python sim_rest(2).py $business_id", $output);

    // Преобразуем строку массива в массив чисел
    $indexes = array_map('intval', explode(' ', trim($output[0], '[]')));

    $response['indexes'] = $indexes; 

    // Выполняем запрос с использованием массива индексов
    $stmt_sim_rest = $connect->prepare("SELECT business_id FROM sim_rest WHERE \"index\" IN (" . implode(',', $indexes) . ")");
    $stmt_sim_rest->execute();
    $result_sim_rest = $stmt_sim_rest->fetchAll(PDO::FETCH_ASSOC);

    // Формируем массив с бизнес-идентификаторами
    $businessIds = array_column($result_sim_rest, 'business_id');

    // Используем метки-плейсхолдеры для корректного выполнения запроса
    $placeholders = str_repeat('?,', count($businessIds) - 1) . '?';

    $statment = $connect->prepare("SELECT business_id, name, city, state, stars, address FROM datta WHERE business_id IN ($placeholders)");
    $statment->execute($businessIds);
    $rest_data = $statment->fetchAll(PDO::FETCH_ASSOC);

    $response['rest_data'] = $rest_data;

    echo json_encode($response);
} else {
    echo "Значения business_id не заданы.";
}
?>
