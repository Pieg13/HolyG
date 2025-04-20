<main class="recipe-details" aria-label="Recipe Details Section">
    <h1 aria-label="Recipe Title"><?php echo htmlspecialchars($recipe['Title']); ?></h1>
    <div class="container">
        <div class="image-container" aria-label="Recipe Image Container">
            <img src="public/<?php echo htmlspecialchars($recipe['ImageURL']); ?>" 
                 alt="Recipe Image" 
                 aria-label="Recipe Image">
        </div>
        <p aria-label="Recipe Author"><strong>Author:</strong> <?php echo htmlspecialchars($recipe['Author']); ?></p>
        <p aria-label="Cooking Time"><strong>Cooking Time:</strong> <?php echo htmlspecialchars($recipe['CookingTime']); ?> minutes</p>
        <p aria-label="Difficulty Level"><strong>Difficulty:</strong> <?php echo htmlspecialchars($recipe['Difficulty']); ?></p>

        <h3 aria-label="Ingredients Section">Ingredients</h3>
        <ul aria-label="Recipe Ingredients List">
            <?php foreach (explode(',', $recipe['Ingredients']) as $ingredient): ?>
                <li aria-label="Ingredient"><?php echo htmlspecialchars($ingredient); ?></li>
            <?php endforeach; ?>
        </ul>

        <h3 aria-label="Instructions Section">Instructions</h3>
        <p aria-label="Recipe Instructions"><?php echo nl2br(htmlspecialchars($recipe['Instructions'])); ?></p>

        <?php if ($recipe['AverageRating']): ?>
            <p aria-label="Average Rating"><strong>Average Rating:</strong> <?php echo htmlspecialchars($recipe['AverageRating']); ?> / 5</p>
        <?php endif; ?>

        <a href="recipes" class="button" aria-label="Back to Recipes Button">Back to Recipes</a>
    </div>