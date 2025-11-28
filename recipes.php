<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Gourmet Discoveries - Recipes</title>
  <style> img{max-width:200px} </style>
</head>
<body>
  <h1>Recipes</h1>
  <div id="list"></div>

<script>
async function fetchList() {
  const res = await fetch('api/recipes.php');
  const data = await res.json();
  const container = document.getElementById('list');
  if (!data.length) {
    container.innerHTML = '<p>No recipes yet. Use import_themealdb.php to add some.</p>';
    return;
  }
  container.innerHTML = data.map(r => `
    <div style="border:1px solid #ddd;padding:10px;margin-bottom:8px">
      <h2>${r.name}</h2>
      <img src="${r.thumbnail}" alt="${r.name}">
      <p><strong>Category:</strong> ${r.category} | <strong>Area:</strong> ${r.area}</p>
      <p><a href="recipe-detail.php?id=${r.id}">View details</a></p>
    </div>
  `).join('');
}
fetchList();
</script>
</body>
</html>
