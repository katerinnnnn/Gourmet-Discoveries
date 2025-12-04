<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "gourmet_discoveries";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(['error'=>'DB connection failed: '.$conn->connect_error]));
}

$data = json_decode(file_get_contents('php://input'), true);
if (!$data || !isset($data['idMeal'])) {
    echo json_encode(['error'=>'No valid data received']);
    exit;
}

$meal_id = $data['idMeal'];
$name = $data['strMeal'] ?? '';
$category = $data['strCategory'] ?? '';
$area = $data['strArea'] ?? '';
$instructions = $data['strInstructions'] ?? '';
$thumbnail = $data['strMealThumb'] ?? '';
$tags = $data['strTags'] ?? '';

// Prepare insert, now meal_id is UNIQUE
$stmt = $conn->prepare("INSERT INTO recipes 
    (meal_id, name, category, area, instructions, thumbnail, tags) 
    VALUES (?, ?, ?, ?, ?, ?, ?)
    ON DUPLICATE KEY UPDATE name=VALUES(name), category=VALUES(category), area=VALUES(area), instructions=VALUES(instructions), thumbnail=VALUES(thumbnail), tags=VALUES(tags)");

$stmt->bind_param("issssss", $meal_id, $name, $category, $area, $instructions, $thumbnail, $tags);
$stmt->execute();

echo json_encode(['saved'=>$stmt->affected_rows, 'meal_id'=>$meal_id]);
$conn->close();
?>
