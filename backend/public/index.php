<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$uri = $_SERVER['REQUEST_URI'];

if ($uri === '/api/health_check') {
    echo json_encode(['status' => 'ok']);
} elseif ($uri === '/api/rolldice') {
    echo json_encode(['dice' => rand(1, 6)]);
} elseif ($uri === '/api/get_current_system_time') {
    echo json_encode(['time' => date('Y:m:d H:i:s')]);
} elseif ($uri === '/api/get_user_info') {
    $names = ['Alice', 'Bob', 'Charlie', 'Diana'];
    echo json_encode([
        'user_id' => rand(1000, 9999),
        'first_name' => $names[array_rand($names)],
        'age' => rand(18, 60)
    ]);
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Not found']);
} 