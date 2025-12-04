<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gourmet_discoveries";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("DB connection failed: " . $conn->connect_error);
}

// Get POST values
$meal_id = $_POST['meal_id'];
$name = $_POST['name'];
$category = $_POST['category'];
$area = $_POST['area'];
$instructions = $_POST['instructions'];
$thumbnail = $_POST['thumbnail'];
$tags = $_POST['tags'] ?? '';

// Prepare insert
$stmt = $conn->prepare("
    INSERT INTO recipes 
        (meal_id, name, category, area, instructions, thumbnail, tags) 
    VALUES (?, ?, ?, ?, ?, ?, ?)
    ON DUPLICATE KEY UPDATE 
        name = VALUES(name),
        category = VALUES(category),
        area = VALUES(area),
        instructions = VALUES(instructions),
        thumbnail = VALUES(thumbnail),
        tags = VALUES(tags)
");

$stmt->bind_param(
    "issssss",
    $meal_id,
    $name,
    $category,
    $area,
    $instructions,
    $thumbnail,
    $tags
);

$stmt->execute();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Favorites Table</title>
    <style>
        table { border-collapse: collapse; width:95%; margin:20px auto; }
        th, td { border:1px solid #ddd; padding:10px; }
        th { background:blue; color:white; }
        img { width:120px; border-radius:5px; }
    </style>
</head>
<body>

<h1 style="text-align:center;">Saved Favorites</h1>

<?php
$result = $conn->query("SELECT * FROM recipes ORDER BY created_at DESC");

echo "<table>";
echo "<tr>
        <th>Thumbnail</th>
        <th>Name</th>
        <th>Category</th>
        <th>Area</th>
        <th>Tags</th>
        <th>Date Added</th>
      </tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td><img src='{$row['thumbnail']}'></td>";
    echo "<td>{$row['name']}</td>";
    echo "<td>{$row['category']}</td>";
    echo "<td>{$row['area']}</td>";
    echo "<td>{$row['tags']}</td>";
    echo "<td>{$row['created_at']}</td>";
    echo "<td> <a href='editData.php?id={$row['meal_id']}'>Edit Tags</a> </td>";

    echo "</tr>";
}

echo "</table>";

$conn->close();
?>

</body>
</html>
