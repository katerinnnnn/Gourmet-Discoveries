<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gourmet_discoveries";

$conn = new mysqli($servername, $username, $password, $dbname);

$id = $_GET['id'] ?? '';

if (!$id) {
    die("Invalid meal ID");
}

$stmt = $conn->prepare("SELECT * FROM recipes WHERE meal_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

$meal = $result->fetch_assoc();

if (!$meal) {
    die("Meal not found.");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Tags</title>
</head>

<body>
<h1>Edit Tags for <?= htmlspecialchars($meal['name']); ?></h1>

<form method="POST" action="update.php">
    <input type="hidden" name="meal_id" value="<?= $meal['meal_id']; ?>">

    <label>Tags (comma-separated):</label><br>
    <input type="text" name="tags" value="<?= htmlspecialchars($meal['tags']); ?>" style="width:300px">

    <br><br>
    <button type="submit">Save Changes</button>
</form>

<br>
<a href="favorite_table.php">Back to Favorites</a>

</body>
</html>
