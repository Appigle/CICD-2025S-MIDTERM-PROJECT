<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Load .env variables
function load_env($path)
{
    if (!file_exists($path)) {
        return;
    }
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }
        list($name, $value) = array_map('trim', explode('=', $line, 2));
        putenv("$name=$value");
    }
}

// Determine environment
$env = getenv('ENV'); // from environment variable
if (!$env) {
    // Try to get from CLI args (for CLI scripts)
    if (php_sapi_name() === 'cli' && isset($argv)) {
        foreach ($argv as $arg) {
            if (strpos($arg, 'env=') === 0) {
                $env = substr($arg, 4);
                break;
            }
        }
    }
}
if (!$env) {
    $env = 'development'; // default
}

// Load the appropriate .env file
$envFile = __DIR__ . '/../.env.' . strtolower($env);
if (file_exists($envFile)) {
    load_env($envFile);
} elseif (file_exists(__DIR__ . '/../.env')) {
    load_env(__DIR__ . '/../.env');
}

$env_name = getenv('ENV_NAME') ?: 'UNKNOWN';
$operation_user = getenv('OPERATION_USER') ?: 'UNKNOWN';

$uri = $_SERVER['REQUEST_URI'];

if ($uri === '/api/health_check') {
    echo json_encode([
        'status' => 'ok',
        'env_name' => $env_name,
        'operation_user' => $operation_user
    ]);
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
