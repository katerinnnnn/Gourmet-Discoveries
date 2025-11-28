<?php
// api/import_themealdb.php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/db.php';

$q = $_GET['q'] ?? 'adobo'; // dish name to search (or pass ?q=adobo)
$apiUrl = "https://www.themealdb.com/api/json/v1/1/search.php?s=" . urlencode($q);

$resp = file_get_contents($apiUrl);
if ($resp === false) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch from TheMealDB']);
    exit;
}

$data = json_decode($resp, true);
if (!$data || $data['meals'] === null) {
    http_response_code(404);
    echo json_encode(['error' => 'No meals found']);
    exit;
}

$meal = $data['meals'][0];

// Build ingredients array
$ingredients = [];
for ($i = 1; $i <= 20; $i++) {
    $ing = trim($meal["strIngredient{$i}"] ?? '');
    $measure = trim($meal["strMeasure{$i}"] ?? '');
    if ($ing !== '') {
        $ingredients[] = ['ingredient' => $ing, 'measure' => $measure];
    }
}

// Check if record from TheMealDB already exists
$check = $pdo->prepare('SELECT id FROM recipes WHERE themealdb_id = ? LIMIT 1');
$check->execute([$meal['idMeal']]);
$existing = $check->fetch();

if ($existing) {
    echo json_encode(['message' => 'Meal already imported', 'id' => $existing['id']]);
    exit;
}

// Insert
$stmt = $pdo->prepare('INSERT INTO recipes (themealdb_id, name, category, area, instructions, thumbnail, ingredients) VALUES (?, ?, ?, ?, ?, ?, ?)');
$stmt->execute([$meal['idMeal'], $meal['strMeal'], $meal['strCategory'], $meal['strArea'], $meal['strInstructions'], $meal['strMealThumb'], json_encode($ingredients, JSON_UNESCAPED_UNICODE)]);
$newId = $pdo->lastInsertId();

echo json_encode(['imported' => true, 'id' => $newId, 'name' => $meal['strMeal']]);
