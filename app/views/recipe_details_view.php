<main class="recipe-details">
    <h1><?php echo htmlspecialchars($recipe['Title']); ?></h1>
    <div class="container">
        <div class="image-container">
            <img src="public/<?php echo htmlspecialchars($recipe['ImageURL']); ?>" alt="Recipe Image">
        </div>
        <p><strong>Author:</strong> <?php echo htmlspecialchars($recipe['Author']); ?></p>
        <p><strong>Cooking Time:</strong> <?php echo htmlspecialchars($recipe['CookingTime']); ?> minutes</p>
        <p><strong>Difficulty:</strong> <?php echo htmlspecialchars($recipe['Difficulty']); ?></p>
        <h3>Ingredients</h3>
        <ul>
            <?php foreach (explode(',', $recipe['Ingredients']) as $ingredient): ?>
                <li><?php echo htmlspecialchars($ingredient); ?></li>
            <?php endforeach; ?>
        </ul>
        <h3>Instructions</h3>
        <p><?php echo nl2br(htmlspecialchars($recipe['Instructions'])); ?></p>

        <?php if ($recipe['AverageRating']): ?>
            <p><strong>Average Rating:</strong> <?php echo htmlspecialchars($recipe['AverageRating']); ?> / 5</p>
        <?php endif; ?>
        <a href="recipes" class="button">Back to Recipes</a>
    </div>