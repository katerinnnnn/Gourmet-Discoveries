const searchForm = document.getElementById('searchForm');
const searchInput = document.getElementById('searchInput');
const resultsContainer = document.getElementById('searchResults');

searchForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const query = searchInput.value.trim();
    if (!query) return;

    resultsContainer.innerHTML = 'Searching...';

    try {
        // 1️⃣ Fetch recipes from TheMealDB
        const res = await fetch(`https://www.themealdb.com/api/json/v1/1/search.php?s=${encodeURIComponent(query)}`);
        const data = await res.json();

        resultsContainer.innerHTML = '';

        if (data.meals) {
            // 2️⃣ This is where your code goes
            data.meals.forEach(async (meal) => {

                // ✅ Save this meal to your database
                await fetch('backend/saveRecipe.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(meal)
                });

                // Build ingredients list
                let ingredients = '';
                for (let i = 1; i <= 20; i++) {
                    const ingredient = meal[`strIngredient${i}`];
                    const measure = meal[`strMeasure${i}`];
                    if (ingredient && ingredient.trim() !== '') {
                        ingredients += `<li>${measure} ${ingredient}</li>`;
                    }
                }

                // Display the recipe
                resultsContainer.innerHTML += `
                    <div class="dish-card">
                        <img src="${meal.strMealThumb}" alt="${meal.strMeal}">
                        <h3>${meal.strMeal}</h3>
                        <p><strong>Category:</strong> ${meal.strCategory}</p>
                        <p><strong>Area:</strong> ${meal.strArea}</p>
                        <h4>Ingredients:</h4>
                        <ul class="ingredients">${ingredients}</ul>
                        <h4>Instructions:</h4>
                        <p>${meal.strInstructions}</p>
                    </div>
                `;
            });
        } else {
            resultsContainer.innerHTML = '<p>No recipes found.</p>';
        }

    } catch (error) {
        resultsContainer.innerHTML = '<p>Error fetching recipes.</p>';
        console.error(error);
    }
});
