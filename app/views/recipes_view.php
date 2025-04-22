<main aria-label="Recipes Section">

    <h1 aria-label="Page Title"><?= $intro ?></h1>
    
    <div class="recipes-grid" aria-label="Recipe List">
        <?php foreach ($recipes as $recipe): ?>
            <article class="recipe-card" aria-label="Recipe Card">
                <div class="image-container" aria-label="Recipe Image">
                    <img src="public/<?= !empty($recipe['ImageURL']) ? htmlspecialchars($recipe['ImageURL']) : 'images/avocado.svg' ?>" 
                         alt="<?= htmlspecialchars($recipe['Title']) ?>">
                </div>
                
                <div class="recipe-content" aria-label="Recipe Details">
                    <h2 class="recipe-title" aria-label="Recipe Title"><?= htmlspecialchars($recipe['Title']) ?></h2>
                    <p class="recipe-author" aria-label="Recipe Author">By <?= htmlspecialchars($recipe['Author']) ?></p>
                    
                    <div class="recipe-group" aria-label="Recipe Metadata">
                        <span class="group-item" aria-label="Cooking Time">
                            ⏱ <?= htmlspecialchars($recipe['CookingTime']) ?> mins
                        </span>
                        <span class="group-item" aria-label="Difficulty Level">
                            🧑🍳 <?= htmlspecialchars($recipe['Difficulty']) ?>
                        </span>
                    </div>

                    <button class="button">
                        <a href="recipe_details&id=<?php echo $recipe['RecipeID']; ?>" aria-label="See More About Recipe">
                            See more
                        </a>
                    </button>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
    
    <?php if (empty($recipes)): ?>
        <p class="no-recipes" aria-label="No Recipes Message">No recipes found!</p>
    <?php endif; ?>