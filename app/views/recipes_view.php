<main>
    
    <h1>Recipes</h1>
    
    <div class="recipes-grid">
        <?php foreach ($recipes as $recipe): ?>
            <article class="recipe-card">
                    <div class="image-container">
                        <img src="public/<?= !empty($recipe['ImageURL']) ? htmlspecialchars($recipe['ImageURL']) : 'images/avocado.svg' ?>" alt="<?= htmlspecialchars($recipe['Title']) ?>">
                    </div>
                
                <div class="recipe-content">
                    <h2 class="recipe-title"><?= htmlspecialchars($recipe['Title']) ?></h2>
                    <p class="recipe-author">By <?= htmlspecialchars($recipe['Author']) ?></p>
                    
                    <div class="recipe-group">
                        <span class="group-item">
                            ⏱ <?= htmlspecialchars($recipe['CookingTime']) ?> mins
                        </span>
                        <span class="group-item">
                            🧑🍳 <?= htmlspecialchars($recipe['Difficulty']) ?>
                        </span>
                    </div>

                    <button class="button">
                        <a href="recipe_details&id=<?php echo $recipe['RecipeID']; ?>">See more</a>
                    </button>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
    
    <?php if (empty($recipes)): ?>
        <p class="no-recipes">No recipes found!</p>
    <?php endif; ?>