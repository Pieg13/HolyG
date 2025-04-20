<?php require APP_DIR . '/views/head_view.php'; ?>

<main>
    <h1>Edit Recipe</h1>

    <form class="basic-form" action="admin&edit=recipe&id=<?= $recipe['RecipeID'] ?>" method="POST" enctype="multipart/form-data">
        
            <label for="title">Title</label>
            <input type="text" id="title" name="title" value="<?= htmlspecialchars($recipe['Title']) ?>" required>

        
            <label for="description">Description</label>
            <textarea id="description" name="description" required><?= htmlspecialchars($recipe['Description']) ?></textarea>

        
            <label for="ingredients">Ingredients</label>
            <textarea required id="ingredients" name="ingredients" required><?= htmlspecialchars($recipe['Ingredients']) ?></textarea>

        
            <label for="instructions">Instructions</label>
            <textarea required id="instructions" name="instructions" required><?= htmlspecialchars($recipe['Instructions']) ?></textarea>

        
            <label for="cooking_time">Cooking Time (minutes)</label>
            <input type="number" id="cooking_time" name="cooking_time" value="<?= htmlspecialchars($recipe['CookingTime']) ?>" required>

        
            <label for="difficulty">Difficulty</label>
            <input type="text" id="difficulty" name="difficulty" value="<?= htmlspecialchars($recipe['Difficulty']) ?>" required>

        
            <label for="image">Image (optional)</label>
            <input type="file" id="image" name="image">
            <?php if ($recipe['ImageURL']): ?>
                <img src="public/<?= htmlspecialchars($recipe['ImageURL']) ?>" alt="Recipe Image" class="preview-image">
            <?php endif; ?>

        <button type="submit" class="button">Save Changes</button>
    </form>
</main>

