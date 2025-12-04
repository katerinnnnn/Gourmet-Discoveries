<!DOCTYPE html>
      <html lang="en">
      <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Gourmet Discoveries</title>

            <link rel="stylesheet" href="Styles/general.css"/>
            <link rel="stylesheet" href="Styles/homeAndCategory.css"/>
            <link rel="stylesheet" href="Styles/dishStyles.css"/>
            <link rel="stylesheet" href="Styles/aboutUs.css"/>
            <link rel="stylesheet" href="Styles/feedback.css"/>
            <link rel="stylesheet" href="Styles/mediaQuerries.css"/>

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
            <nav id="nav1">
                  <div id="heather">
                  <ul id="navLinks">
                        <li><a href="index2.php">Home</a></li>
                        <li><a href="/backend/recipes.php" target="_blank">Show</a></li>
                        
                        <li><a href="#aboutUs">About Us</a></li>
                  </ul>
                  </div>
            </nav>

            <main>
                  <section id="home">
                  <div id="mabuhay"><p>MABUHAY!</p></div>
                  <p id="name">GOURMET DISCOVERIES</p>
                  </section>
                  
                  <div>
                        <h1>Search Recipes</h1>
                        <form method="GET" action="backend/results.php">
                        <input type="text" name="searchInput" placeholder="Search recipe..." required>
                        <button type="submit">Search</button>
                        </form>
                  </div>

      <!--Category page-->
                  
            </main>
            <!-- <footer>
                  <p>Copyright &#169 4 Gourmet Discoveries. All Rights Reserved.</p>
            </footer> -->
      </body>
</html>

   