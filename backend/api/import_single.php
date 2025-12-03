<?php
require_once __DIR__ . '/../config.php';
header("Content-Type: application/json");

// 1. Get meal ID
$id = isset($_GET['id']) ? trim($_GET['id']) : '';
if ($id === '') {
    echo json_encode(["error"=>"Please provide meal ID, e.g. ?id=52771"]);
    exit;
}

// 2. Fetch from TheMealDB
$url = "https://www.themealdb.com/api/json/v1/1/lookup.php?i=" . urlencode($id);
$response = @file_get_contents($url);

if ($response === false) {
    echo json_encode(["error"=>"Failed to fetch TheMealDB"]);
    exit;
}

$data = json_decode($response, true);
$meal = $data["meals"][0] ?? null;
if (!$meal) {
    echo json_encode(["error"=>"Meal not found"]);
    exit;
}

// 3. Skip if already exists
$check = $pdo->prepare("SELECT id FROM meals WHERE mealdb_id = ?");
$check->execute([$meal["idMeal"]]);
if ($check->fetch()) {
    echo json_encode(["message"=>"Meal already exists in DB"]);
    exit;
}

// 4. Build ingredients array
$ingredients = [];
for ($i=1; $i<=20; $i++) {
    $ing = $meal["strIngredient$i"] ?? "";
    $mea = $meal["strMeasure$i"] ?? "";
    if ($ing && trim($ing)!=="") {
        $ingredients[] = ["ingredient"=>$ing,"measure"=>$mea];
    }
}

// 5. Insert into DB
$stmt = $pdo->prepare("
    INSERT INTO meals 
    (mealdb_id, name, category, area, instructions, thumbnail, tags, youtube, ingredients, source_url)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");
$stmt->execute([
    $meal["idMeal"],
    $meal["strMeal"],
    $meal["strCategory"],
    $meal["strArea"],
    $meal["strInstructions"],
    $meal["strMealThumb"],
    $meal["strTags"],
    $meal["strYoutube"],
    json_encode($ingredients, JSON_UNESCAPED_UNICODE),
    $meal["strSource"]
]);

echo json_encode(["message"=>"Meal imported successfully", "id"=>$pdo->lastInsertId()]);
