<main class="main-content">
    <h1 class="main-title">Recipes</h1>
    
    <div class="recipes-grid">
        <?php foreach ($recipes as $recipe): ?>
            <article class="recipe-card">
                <?php if ($recipe['ImageURL']): ?>
                    <img src="public/<?= htmlspecialchars($recipe['ImageURL']) ?>" 
                         alt="<?= htmlspecialchars($recipe['Title']) ?>" 
                         class="recipe-image">
                <?php else: ?>
                    <div class="recipe-image placeholder-image"></div>
                <?php endif; ?>
                
                <div class="recipe-content">
                    <h2 class="recipe-title"><?= htmlspecialchars($recipe['Title']) ?></h2>
                    <p class="recipe-author">By <?= htmlspecialchars($recipe['Author']) ?></p>
                    
                    <div class="recipe-meta">
                        <span class="cooking-time">
                            ⏱ <?= htmlspecialchars($recipe['CookingTime']) ?> mins
                        </span>
                        <span class="difficulty">
                            🧑🍳 <?= htmlspecialchars($recipe['Difficulty']) ?>
                        </span>
                    </div>
                    
                    <p class="recipe-description">
                        <?= htmlspecialchars($recipe['Description']) ?>
                    </p>
                    <button class="button recipe-button">See more</button>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
    
    <?php if (empty($recipes)): ?>
        <p class="no-recipes">No recipes found!</p>
    <?php endif; ?>
</main>