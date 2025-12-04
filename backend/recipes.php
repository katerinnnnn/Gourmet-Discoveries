 <?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = ""; // MySQL password
$dbname = "gourmet_discoveries";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die(json_encode(['error' => 'DB connection failed']));

$data = json_decode(file_get_contents('php://input'), true);

// Insert into DB
$stmt = $conn->prepare("INSERT IGNORE INTO recipes 
    (meal_id, name, category, area, instructions, thumbnail, tags) 
    VALUES (?, ?, ?, ?, ?, ?, ?)");
$tags = $data['strTags'] ?? '';
$stmt->bind_param(
    "issssss",
    $data['idMeal'],
    $data['strMeal'],
    $data['strCategory'],
    $data['strArea'],
    $data['strInstructions'],
    $data['strMealThumb'],
    $tags
);
$stmt->execute();

echo json_encode(['saved' => $stmt->affected_rows]);

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $search = isset($_GET['q']) ? $_GET['q'] : '';

    if ($search) {
        // Check DB first
        $stmt = $conn->prepare("SELECT * FROM recipes WHERE name LIKE ?");
        $like = "%$search%";
        $stmt->bind_param("s", $like);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo json_encode($result->fetch_all(MYSQLI_ASSOC));
        } else {
            // Fetch from TheMealDB
            $api_url = "https://www.themealdb.com/api/json/v1/1/search.php?s=" . urlencode($search);
            $response = file_get_contents($api_url);
            $data = json_decode($response, true);

            if ($data['meals']) {
                foreach ($data['meals'] as $meal) {
                    $stmt = $conn->prepare(
                        "INSERT IGNORE INTO recipes (meal_id, name, category, area, instructions, thumbnail, tags) VALUES (?, ?, ?, ?, ?, ?, ?)"
                    );
                    $tags = $meal['strTags'] ?? '';
                    $stmt->bind_param(
                        "issssss",
                        $meal['idMeal'],
                        $meal['strMeal'],
                        $meal['strCategory'],
                        $meal['strArea'],
                        $meal['strInstructions'],
                        $meal['strMealThumb'],
                        $tags
                    );
                    $stmt->execute();
                }
                echo json_encode($data['meals']);
            } else {
                echo json_encode([]);
            }
        }
    } else {
        $result = $conn->query("SELECT * FROM recipes");
        echo json_encode($result->fetch_all(MYSQLI_ASSOC));
    }
}
?>
