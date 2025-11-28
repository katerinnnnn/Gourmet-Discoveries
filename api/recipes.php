<?php
// api/recipes.php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../db.php';

// Allow simple CORS while developing (remove or restrict in production)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

$method = $_SERVER['REQUEST_METHOD'];
$path = isset($_GET['id']) ? intval($_GET['id']) : null;

if ($method === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($method === 'GET') {
    if ($path) {
        // GET single recipe
        $stmt = $pdo->prepare('SELECT * FROM recipes WHERE id = ?');
        $stmt->execute([$path]);
        $row = $stmt->fetch();
        if ($row) {
            $row['ingredients'] = json_decode($row['ingredients'], true);
            echo json_encode($row);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Recipe not found.']);
        }
    } else {
        // GET list
        $stmt = $pdo->query('SELECT id, name, category, area, thumbnail, created_at FROM recipes ORDER BY created_at DESC');
        $rows = $stmt->fetchAll();
        echo json_encode($rows);
    }
    exit;
}

$body = json_decode(file_get_contents('php://input'), true) ?: [];

// POST -> create new recipe
if ($method === 'POST') {
    $name = $body['name'] ?? null;
    if (!$name) {
        http_response_code(400);
        echo json_encode(['error' => 'Name required']);
        exit;
    }
    $stmt = $pdo->prepare('INSERT INTO recipes (themealdb_id, name, category, area, instructions, thumbnail, ingredients) VALUES (?, ?, ?, ?, ?, ?, ?)');
    $ingredientsJson = isset($body['ingredients']) ? json_encode($body['ingredients'], JSON_UNESCAPED_UNICODE) : json_encode([]);
    $stmt->execute([$body['themealdb_id'] ?? null, $name, $body['category'] ?? null, $body['area'] ?? null, $body['instructions'] ?? null, $body['thumbnail'] ?? null, $ingredientsJson]);
    $newId = $pdo->lastInsertId();
    http_response_code(201);
    echo json_encode(['id' => $newId]);
    exit;
}

// PUT -> update
if ($method === 'PUT' && $path) {
    $stmt = $pdo->prepare('UPDATE recipes SET themealdb_id=?, name=?, category=?, area=?, instructions=?, thumbnail=?, ingredients=? WHERE id=?');
    $ingredientsJson = isset($body['ingredients']) ? json_encode($body['ingredients'], JSON_UNESCAPED_UNICODE) : json_encode([]);
    $stmt->execute([$body['themealdb_id'] ?? null, $body['name'] ?? null, $body['category'] ?? null, $body['area'] ?? null, $body['instructions'] ?? null, $body['thumbnail'] ?? null, $ingredientsJson, $path]);
    echo json_encode(['updated' => true]);
    exit;
}

// DELETE -> delete
if ($method === 'DELETE' && $path) {
    $stmt = $pdo->prepare('DELETE FROM recipes WHERE id = ?');
    $stmt->execute([$path]);
    echo json_encode(['deleted' => true]);
    exit;
}

http_response_code(405);
echo json_encode(['error' => 'Method not allowed']);
