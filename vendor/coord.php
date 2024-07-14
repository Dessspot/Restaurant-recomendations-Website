<?php
// Получение значений из формы
require 'connect.php';
$longitude = isset($_POST['longitude']) ? $_POST['longitude'] : null;
$latitude = isset($_POST['latitude']) ? $_POST['latitude'] : null;

$response = []; 
 
if ($longitude !== null && $latitude !== null) {
    // Вызов питоновского скрипта
    exec("python coord.py $longitude $latitude", $output);

    // Вывод результатов в формате JSON
    $response['cluster'] = $output[0];

    $statement = $connect->prepare("SELECT datta.business_id, datta.name, datta.stars, datta.address, COALESCE(COUNT(revrev.business_id), 0) as comment_count
    FROM datta
    LEFT JOIN revrev ON datta.business_id = revrev.business_id
    WHERE datta.cluster = :cluster
    GROUP BY datta.business_id, datta.name, datta.stars, datta.address
    HAVING COALESCE(COUNT(revrev.business_id), 0) > 10
    ORDER BY datta.stars DESC, comment_count DESC LIMIT 10");
    $statement->bindParam(':cluster', $response['cluster']);
    $statement->execute();
    $recommendations = $statement->fetchAll(PDO::FETCH_ASSOC);

    $response['recommendations'] = $recommendations;

    echo json_encode($response);
} else {
    echo json_encode(['error' => 'Значения долготы и широты не заданы.']);
} 
?>
