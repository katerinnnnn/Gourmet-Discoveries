<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Styles/general.css"/>
            <link rel="stylesheet" href="../Styles/homeAndCategory.css"/>
            <link rel="stylesheet" href="../Styles/newStyles.css">
</head>
<body>
    <nav id="nav1">
        <div id="heather">
        <ul id="navLinks">
            <li><a href="index2.php">Home</a></li>
            <li><a href="/backend/recipes.php" target="_blank">Show</a></li>
            
            <li><a href="#aboutUs">About Us</a></li>
        </ul>
        </div>
    </nav>
    <?php
    $id = $_GET['id'] ?? '';

    if (!$id) {
        die("Invalid Meal ID");
    }

    $url = "https://www.themealdb.com/api/json/v1/1/lookup.php?i=" . $id;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);
    $meal = $data['meals'][0];
    ?>

    <h1><?php echo $meal['strMeal']; ?></h1>

    <img src="<?php echo $meal['strMealThumb']; ?>" width="350"><br>

    <p><strong>Category:</strong> <?php echo $meal['strCategory']; ?></p>
    <p><strong>Area:</strong> <?php echo $meal['strArea']; ?></p>

    <h2>Ingredients</h2>
    <ul>
    <?php
    for ($i = 1; $i <= 20; $i++) {
        $ingredient = $meal["strIngredient$i"];
        $measure = $meal["strMeasure$i"];

        if ($ingredient) {
            echo "<li>$ingredient - $measure</li>";
        }
    }
    ?>
    </ul>

    <h2>Instructions</h2>
    <p><?php echo nl2br($meal['strInstructions']); ?></p>

    <a href="results.php">Back to results</a>
</body>
</html>