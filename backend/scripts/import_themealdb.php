<?php
// backend/scripts/import_themealdb.php
// Usage: php import_themealdb.php 52772
require_once __DIR__ . '/../config.php';

if (php_sapi_name() === 'cli') {
    $argvId = $argv[1] ?? null;
    if (!$argvId) {
        echo "Usage: php import_themealdb.php <mealdb_id>\n";
        exit(1);
    }
    $mealdb_id = (int)$argvId;
} else {
    $mealdb_id = isset($_GET['mealdb_id']) ? (int)$_GET['mealdb_id'] : null;
}

if (!$mealdb_id) {
    echo json_encode(["error"=>"mealdb_id required"]);
    exit;
}

$apiUrl = "https://www.themealdb.com/api/json/v1/1/lookup.php?i={$mealdb_id}";

// fetch (use cURL for robust HTTPS)
$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
$response = curl_exec($ch);
$err = curl_error($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($err || $http_code !== 200) {
    echo json_encode(["error"=>"failed fetch remote", "details"=>$err, "http_code"=>$http_code]);
    exit;
}

$payload = json_decode($response, true);
if (empty($payload['meals'])) {
    echo json_encode(["error"=>"no meal found for id {$mealdb_id}"]);
    exit;
}

$meal = $payload['meals'][0];

// build ingredients array
$ingredients = [];
for ($i=1; $i<=20; $i++) {
    $ing = trim($meal["strIngredient{$i}"] ?? '');
    $measure = trim($meal["strMeasure{$i}"] ?? '');
    if ($ing !== '') {
        $ingredients[] = ["ingredient" => $ing, "measure" => $measure];
    }
}

$exists = $pdo->prepare("SELECT id FROM meals WHERE mealdb_id = ?");
$exists->execute([$mealdb_id]);
$existing = $exists->fetchColumn();

// upsert
if ($existing) {
    $stmt = $pdo->prepare("UPDATE meals SET name=?, category=?, area=?, instructions=?, thumbnail=?, tags=?, youtube=?, ingredients=?, source_url=?, updated_at = NOW() WHERE mealdb_id = ?");
    $stmt->execute([
        $meal['strMeal'],
        $meal['strCategory'],
        $meal['strArea'],
        $meal['strInstructions'],
        $meal['strMealThumb'],
        $meal['strTags'],
        $meal['strYoutube'],
        json_encode($ingredients, JSON_UNESCAPED_UNICODE),
        $meal['strSource'] ?? null,
        $mealdb_id
    ]);
    echo json_encode(["updated" => $existing]);
} else {
    $stmt = $pdo->prepare("INSERT INTO meals (mealdb_id, name, category, area, instructions, thumbnail, tags, youtube, ingredients, source_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $mealdb_id,
        $meal['strMeal'],
        $meal['strCategory'],
        $meal['strArea'],
        $meal['strInstructions'],
        $meal['strMealThumb'],
        $meal['strTags'],
        $meal['strYoutube'],
        json_encode($ingredients, JSON_UNESCAPED_UNICODE),
        $meal['strSource'] ?? null
    ]);
    echo json_encode(["inserted_id" => $pdo->lastInsertId()]);
}
