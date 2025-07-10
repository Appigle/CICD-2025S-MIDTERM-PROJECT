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

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($uri === '/' || $uri === '') {
    // API Documentation page
    header('Content-Type: text/html');
    echo '<!DOCTYPE html>
<html>
<head>
    <title>RollDice API</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #333; border-bottom: 3px solid #007bff; padding-bottom: 10px; }
        .endpoint { background: #f8f9fa; border-left: 4px solid #007bff; padding: 15px; margin: 15px 0; border-radius: 4px; }
        .method { background: #28a745; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; }
        code { background: #e9ecef; padding: 2px 6px; border-radius: 3px; font-family: "Courier New", monospace; }
        .info { background: #e3f2fd; border: 1px solid #2196f3; padding: 15px; border-radius: 4px; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎲 RollDice API</h1>
        <div class="info">
            <strong>Environment:</strong> ' . htmlspecialchars($env_name) . '<br>
            <strong>User:</strong> ' . htmlspecialchars($operation_user) . '<br>
            <strong>Server Time:</strong> ' . date('Y-m-d H:i:s') . '
        </div>
        
        <h2>Available Endpoints</h2>
        
        <div class="endpoint">
            <span class="method">GET</span> <code>/api/health_check</code>
            <p>Returns API status and environment information</p>
        </div>
        
        <div class="endpoint">
            <span class="method">GET</span> <code>/api/rolldice</code>
            <p>Returns a random dice roll (1-6)</p>
        </div>
        
        <div class="endpoint">
            <span class="method">GET</span> <code>/api/get_current_system_time</code>
            <p>Returns current server timestamp</p>
        </div>
        
        <div class="endpoint">
            <span class="method">GET</span> <code>/api/get_user_info</code>
            <p>Returns random user information</p>
        </div>
        
        <h2>Test Links</h2>
        <p>
            <a href="/api/health_check" target="_blank">Health Check</a> | 
            <a href="/api/rolldice" target="_blank">Roll Dice</a> | 
            <a href="/api/get_current_system_time" target="_blank">Get Time</a> | 
            <a href="/api/get_user_info" target="_blank">User Info</a>
        </p>
    </div>
</body>
</html>';
} elseif ($uri === '/api/health_check') {
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
