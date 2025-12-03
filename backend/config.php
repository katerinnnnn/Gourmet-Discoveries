<?php
// backend/config.php
header("Access-Control-Allow-Origin: *"); // tweak to your domain in production
header("Content-Type: application/json; charset=UTF-8");

date_default_timezone_set('Asia/Manila');

$DB_HOST = getenv('DB_HOST') ?: '127.0.0.1';
$DB_USER = getenv('DB_USER') ?: 'root';
$DB_PASS = getenv('DB_PASS') ?: '';
$DB_NAME = getenv('DB_NAME') ?: 'gourmet_discoveries';
$DB_PORT = getenv('DB_PORT') ?: 3306;

try {
    $pdo = new PDO("mysql:host=$DB_HOST;port=$DB_PORT;dbname=$DB_NAME;charset=utf8mb4", $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "DB connection failed", "details" => $e->getMessage()]);
    exit;
}

function json_response($data, $status = 200) {
    http_response_code($status);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

function parse_json_body() {
    $body = file_get_contents('php://input');
    return json_decode($body, true);
}
