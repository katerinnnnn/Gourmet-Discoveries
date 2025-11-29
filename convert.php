<?php
// Load TheMealDB JSON
$rawJson = file_get_contents('meal.json'); // Save TheMealDB JSON in meal.json
$data = json_decode($rawJson, true);

// Take the first meal
$meal = $data['meals'][0];

// Convert to POST format
$postData = [
    "name" => $meal['strMeal'],
    "category" => $meal['strCategory'],
    "area" => $meal['strArea'],
    "instructions" => $meal['strInstructions'],
    "thumbnail" => $meal['strMealThumb'],
    "ingredients" => []
];

// Loop through ingredients 1-20
for ($i = 1; $i <= 20; $i++) {
    $ingredient = $meal["strIngredient$i"];
    $measure = $meal["strMeasure$i"];
    if (!empty($ingredient)) {
        $postData['ingredients'][] = [
            "ingredient" => $ingredient,
            "measure" => $measure
        ];
    }
}

// Output JSON ready for POST
echo json_encode($postData, JSON_PRETTY_PRINT);
