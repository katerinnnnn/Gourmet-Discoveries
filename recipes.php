<?php
header('Content-Type: application/json');
require_once('../db.php'); // include database connection

$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        // Fetch meals from TheMealDB
        $search = isset($_GET['q']) ? $_GET['q'] : "";
        $api_url = "https://www.themealdb.com/api/json/v1/1/search.php?s=" . urlencode($search);
        $response = file_get_contents($api_url);
        $data = json_decode($response, true);

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
        echo json_encode($filtered);
        break;

    case 'POST':
        // Add a favorite meal to local DB
        $input = json_decode(file_get_contents('php://input'), true);
        if(isset($input['name'])) {
            $stmt = $pdo->prepare("INSERT INTO recipes (name, category, area, instructions, thumbnail) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([
                $input['name'],
                $input['category'] ?? '',
                $input['area'] ?? '',
                $input['instructions'] ?? '',
                $input['thumbnail'] ?? ''
            ]);
            echo json_encode(['status' => 'success', 'id' => $pdo->lastInsertId()]);
        } else {
            echo json_encode(['error' => 'Name is required']);
        }
        break;

    case 'PUT':
        // Update a recipe in local DB
        $input = json_decode(file_get_contents('php://input'), true);
        if(isset($input['id'])) {
            $stmt = $pdo->prepare("UPDATE recipes SET name=?, category=?, area=?, instructions=?, thumbnail=? WHERE id=?");
            $stmt->execute([
                $input['name'] ?? '',
                $input['category'] ?? '',
                $input['area'] ?? '',
                $input['instructions'] ?? '',
                $input['thumbnail'] ?? '',
                $input['id']
            ]);
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['error' => 'ID is required']);
        }
        break;

    case 'DELETE':
        // Delete a recipe in local DB
        $input = json_decode(file_get_contents('php://input'), true);
        if(isset($input['id'])) {
            $stmt = $pdo->prepare("DELETE FROM recipes WHERE id=?");
            $stmt->execute([$input['id']]);
            echo json_encode(['status' => 'deleted']);
        } else {
            echo json_encode(['error' => 'ID is required']);
        }
        break;

    default:
        echo json_encode(['error' => 'Invalid method']);
        break;
}
