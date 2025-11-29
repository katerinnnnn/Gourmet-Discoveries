<?php
// TheMealDB API URL (example: fetch one random meal)
$apiUrl = 'https://www.themealdb.com/api/json/v1/1/random.php';

// Fetch data from TheMealDB
$rawJson = file_get_contents($apiUrl);
if (!$rawJson) {
    die("Error: Unable to fetch data from TheMealDB.");
}

$data = json_decode($rawJson, true);
if (!$data || !isset($data['meals'][0])) {
    die("Error: Invalid response from TheMealDB.");
}

// Take the first meal
$meal = $data['meals'][0];

// Convert to your API POST format
$postData = [
    "name" => $meal['strMeal'],
    "category" => $meal['strCategory'],
    "area" => $meal['strArea'],
    "instructions" => $meal['strInstructions'],
    "thumbnail" => $meal['strMealThumb'],
    "ingredients" => []
];

// Loop through ingredients 1–20
for ($i = 1; $i <= 20; $i++) {
    $ingredient = $meal["strIngredient$i"];
    $measure = $meal["strMeasure$i"];
    if (!empty($ingredient) && $ingredient != "") {
        $postData['ingredients'][] = [
            "ingredient" => $ingredient,
            "measure" => $measure
        ];
    }
}

// Output JSON ready for POST
header('Content-Type: application/json');
echo json_encode($postData, JSON_PRETTY_PRINT);
