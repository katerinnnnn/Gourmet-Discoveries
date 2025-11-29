<?php
header('Content-Type: application/json'); // tells browser/Postman this is JSON

// URL of TheMealDB API
$api_url = "https://www.themealdb.com/api/json/v1/1/search.php?s=";

// Optional: get a search query from GET parameters
$search = isset($_GET['q']) ? $_GET['q'] : "";
$api_url .= urlencode($search);

// Fetch data from TheMealDB
$response = file_get_contents($api_url);

// Decode JSON to array (optional if you want to manipulate)
$data = json_decode($response, true);

// Optionally: filter or manipulate data here
// Example: only return id, name, category
$filtered = [];
if (!empty($data['meals'])) {
    foreach ($data['meals'] as $meal) {
        $filtered[] = [
            'id' => $meal['idMeal'],
            'name' => $meal['strMeal'],
            'category' => $meal['strCategory'],
            'area' => $meal['strArea'],
            'instructions' => $meal['strInstructions'],
            'thumbnail' => $meal['strMealThumb']
        ];
    }
}

// Return JSON
echo json_encode($filtered);
