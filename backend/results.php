<!DOCTYPE html>
      <html lang="en">
      <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Gourmet Discoveries</title>

            <link rel="stylesheet" href="Styles/general.css"/>
            <link rel="stylesheet" href="../Styles/homeAndCategory.css"/>
            <link rel="stylesheet" href="../Styles/newStyles.css">

      <style>
      body { font-family: Arial, sans-serif; margin: 20px; }
      .dish-container { display: flex; flex-wrap: wrap; gap: 20px; }
      .dish-card { border: 1px solid #ccc; padding: 10px; width: 250px; }
      .dish-card img { width: 100%; height: auto; }
      .ingredients { font-size: 14px; padding-left: 15px; }
      h1 { margin-bottom: 10px; }
      form { margin-bottom: 20px; }
      </style>
      
      </head>
      
      <body>
        <header>
            <nav id="nav1">
                  <div id="heather">
                  <ul id="navLinks">
                        <li><a href="../index2.php">Home</a></li>
                        <li><a href="/backend/recipes.php" target="_blank">Show</a></li>
                        
                        <li><a href="#aboutUs">About Us</a></li>
                  </ul>
                  </div>
            </nav>
        </header>
            <main>
                <div class='d-container'>
                <?php 

                $food = $_GET['searchInput'] ?? '';
                 if (!$food){
                 die("No search found");
                }       
                $url = "https://www.themealdb.com/api/json/v1/1/search.php?s=" . urlencode($food);
        
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $response = curl_exec($ch);

                if ($response === false){
                    echo "cURL Error: " .
                    curl_error($ch);
                    curl_close($ch);
                    exit;
                }

                curl_close($ch);

                $data = json_decode($response, true);

                if (!empty($data['meals'])){
                    foreach ($data['meals'] as $meal){
                        echo "<div class='d-card'>";
                        echo "<img src='" . $meal['strMealThumb'] . "' alt='' class='meal-thumb'>";
                        echo "<h3>" . $meal['strMeal'] . "</h3>";
                        echo "<p><strong>Category:</strong> " . $meal['strCategory'] . "</p>";
                        echo "<p><strong>Area:</strong> " . $meal['strArea'] . "</p>";

                        echo "<a href='view.php?id=" . $meal['idMeal'] . "' class='view-btn'>View Details</a>";
 
                        echo "</div>";
                    }
                }
                else{
                    echo "No meals found";
                }
                ?>
                </div>
            </main>
                
      </body>
</html>



