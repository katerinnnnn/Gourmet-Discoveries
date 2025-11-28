<?php
// Step 1: Check if ID is provided
if (!isset($_GET['id'])) {
    die("No recipe ID provided.");
}

$recipeId = intval($_GET['id']);  // sanitize id

// Step 2: Call your local backend API
$apiUrl = "http://localhost/Gourmet-Discoveries/api/recipes.php?id=" . $recipeId;

$response = file_get_contents($apiUrl);

if ($response === FALSE) {
    die("Error: Cannot connect to API.");
}

// Step 3: Convert JSON → PHP Array
$recipe = json_decode($response, true);

// Step 4: Check if recipe exists
if (!$recipe || !isset($recipe['idMeal'])) {
    die("Recipe not found.");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $recipe['strMeal']; ?> | Recipe Details</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        img { width: 350px; border-radius: 10px; }
        .container { max-width: 800px; margin: auto; }
        .ingredients { margin-top: 20px; }
    </style>
</head>
<body>

<div class="container">

    <h1><?php echo $recipe['strMeal']; ?></h1>

    <img src="<?php echo $recipe['strMealThumb']; ?>" alt="Meal Image">

    <h2>Category: <?php echo $recipe['strCategory']; ?></h2>
    <h3>Origin: <?php echo $recipe['strArea']; ?></h3>

    <h2>Ingredients</h2>
    <ul>
        <?php
        // Step 5: Loop ingredients (MealDB uses ingredient1, ingredient2...)
        for ($i = 1; $i <= 20; $i++) {
            $ingredient = $recipe["strIngredient" . $i];
            $measure = $recipe["strMeasure" . $i];

            if (!empty($ingredient)) {
                echo "<li>$ingredient - $measure</li>";
            }
        }
        ?>
    </ul>

    <h2>Instructions</h2>
    <p><?php echo nl2br($recipe['strInstructions']); ?></p>

</div>

</body>
</html>
