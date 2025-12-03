<?php
// backend/api/recipes.php
require_once __DIR__ . '/../config.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    if (isset($_GET['id'])) {
        $stmt = $pdo->prepare("SELECT * FROM meals WHERE id = ?");
        $stmt->execute([$_GET['id']]);
        $meal = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$meal) json_response(["error" => "Not found"], 404);
        $meal['ingredients'] = json_decode($meal['ingredients'] ?? '[]', true);
        json_response($meal);
    }

    // search or list
    $q = isset($_GET['q']) ? trim($_GET['q']) : '';
    if ($q !== '') {
        $stmt = $pdo->prepare("SELECT * FROM meals WHERE name LIKE ? ORDER BY name LIMIT 100");
        $stmt->execute(["%$q%"]);
    } else {
        $stmt = $pdo->query("SELECT * FROM meals ORDER BY created_at DESC LIMIT 200");
    }
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as &$r) {
        $r['ingredients'] = json_decode($r['ingredients'] ?? '[]', true);
    }
    json_response($rows);
}

if ($method === 'POST') {
    $data = parse_json_body();
    if (empty($data['name'])) json_response(["error" => "name required"], 400);

    $ingredients_json = isset($data['ingredients']) ? json_encode($data['ingredients'], JSON_UNESCAPED_UNICODE) : null;

    $stmt = $pdo->prepare("INSERT INTO meals (mealdb_id, name, category, area, instructions, thumbnail, tags, youtube, ingredients, source_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $data['mealdb_id'] ?? null,
        $data['name'],
        $data['category'] ?? null,
        $data['area'] ?? null,
        $data['instructions'] ?? null,
        $data['thumbnail'] ?? null,
        $data['tags'] ?? null,
        $data['youtube'] ?? null,
        $ingredients_json,
        $data['source_url'] ?? null
    ]);
    $id = $pdo->lastInsertId();
    json_response(["id" => (int)$id], 201);
}

if ($method === 'PUT') {
    if (!isset($_GET['id'])) json_response(["error" => "id required"], 400);
    $id = (int)$_GET['id'];
    $data = parse_json_body();
    $fields = [];
    $params = [];

    $updatable = ['name','category','area','instructions','thumbnail','tags','youtube','source_url','mealdb_id','ingredients'];
    foreach ($updatable as $f) {
        if (array_key_exists($f, $data)) {
            if ($f === 'ingredients') {
                $fields[] = "$f = ?";
                $params[] = json_encode($data[$f], JSON_UNESCAPED_UNICODE);
            } else {
                $fields[] = "$f = ?";
                $params[] = $data[$f];
            }
        }
    }
    if (empty($fields)) json_response(["error"=>"no fields provided"], 400);
    $params[] = $id;
    $sql = "UPDATE meals SET " . implode(', ', $fields) . " WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    json_response(["updated" => $id]);
}

if ($method === 'DELETE') {
    if (!isset($_GET['id'])) json_response(["error" => "id required"], 400);
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM meals WHERE id = ?");
    $stmt->execute([$id]);
    json_response(["deleted" => $id]);
}

json_response(["error"=>"method not allowed"], 405);
