<?php
require_once __DIR__ . '/../config.php';
header("Content-Type: application/json");

// ----------- 1. Validate keyword -----------
$search = isset($_GET['s']) ? trim($_GET['s']) : '';
if ($search === '') {
    echo json_encode(["error" => "Please provide search keyword ?s=adobo"]);
    exit;
}

// ----------- 2. Fetch from TheMealDB -----------
$url = "https://www.themealdb.com/api/json/v1/1/search.php?s=" . urlencode($search);
$response = @file_get_contents($url);

if ($response === false) {
    echo json_encode(["error" => "Failed to fetch TheMealDB"]);
    exit;
}

$data = json_decode($response, true);
$meals = $data["meals"] ?? null;

if (!$meals) {
    echo json_encode(["message" => "No meals found for '$search'"]);
    exit;
}

$imported = 0;
$skipped = 0;

// ----------- 3. Insert each meal into MySQL -----------
foreach ($meals as $m) {

    // Skip if already exists
    $check = $pdo->prepare("SELECT id FROM meals WHERE mealdb_id = ?");
    $check->execute([$m["idMeal"]]);
    if ($check->fetch()) {
        $skipped++;
        continue;
    }

    // Build ingredients array
    $ingredients = [];
    for ($i = 1; $i <= 20; $i++) {
        $ing = $m["strIngredient$i"] ?? "";
        $mea = $m["strMeasure$i"] ?? "";
        if ($ing && trim($ing) !== "") {
            $ingredients[] = [
                "ingredient" => $ing,
                "measure" => $mea
            ];
        }
    }

    // Insert into DB
    $stmt = $pdo->prepare("
        INSERT INTO meals 
        (mealdb_id, name, category, area, instructions, thumbnail, tags, youtube, ingredients, source_url) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $m["idMeal"],
        $m["strMeal"],
        $m["strCategory"],
        $m["strArea"],
        $m["strInstructions"],
        $m["strMealThumb"],
        $m["strTags"],
        $m["strYoutube"],
        json_encode($ingredients, JSON_UNESCAPED_UNICODE),
        $m["strSource"]
    ]);

    $imported++;
}

// ----------- 4. Output summary -----------
echo json_encode([
    "search" => $search,
    "imported" => $imported,
    "skipped_duplicates" => $skipped,
    "status" => "done"
]);
?>
