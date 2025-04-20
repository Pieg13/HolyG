<?php require APP_DIR . '/views/head_view.php'; ?>

<main aria-label="Edit Recipe Section">
    <h1 aria-label="Page Title">Edit Recipe</h1>

    <?php if (!empty($_SESSION['form_errors'])): ?>
        <div class="container" aria-label="Form Error Messages">
            <?php foreach ($_SESSION['form_errors'] as $error): ?>
                <p class="error-p" aria-label="Error Message"><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        </div>
        <?php unset($_SESSION['form_errors']); ?>
    <?php endif; ?>

    <form class="basic-form" action="admin&edit=recipe&id=<?= $recipe['RecipeID'] ?>" method="POST" enctype="multipart/form-data" aria-label="Edit Recipe Form">
        
        <label for="title">Title</label>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($recipe['Title']) ?>" required aria-label="Recipe Title Input">

        <label for="description">Description</label>
        <textarea id="description" name="description" required aria-label="Recipe Description Input"><?= htmlspecialchars($recipe['Description']) ?></textarea>

        <label for="ingredients">Ingredients</label>
        <textarea id="ingredients" name="ingredients" required aria-label="Recipe Ingredients Input"><?= htmlspecialchars($recipe['Ingredients']) ?></textarea>

        <label for="instructions">Instructions</label>
        <textarea id="instructions" name="instructions" required aria-label="Recipe Instructions Input"><?= htmlspecialchars($recipe['Instructions']) ?></textarea>

        <label for="cooking_time">Cooking Time (minutes)</label>
        <input type="number" id="cooking_time" name="cooking_time" value="<?= htmlspecialchars($recipe['CookingTime']) ?>" required aria-label="Cooking Time Input">

        <label for="difficulty">Difficulty</label>
        <input type="text" id="difficulty" name="difficulty" value="<?= htmlspecialchars($recipe['Difficulty']) ?>" required aria-label="Difficulty Level Input">

        <label for="image">Image (optional)</label>
        <input type="file" id="image" name="image" aria-label="Upload Recipe Image">
        <?php if ($recipe['ImageURL']): ?>
            <img src="public/<?= htmlspecialchars($recipe['ImageURL']) ?>" alt="Recipe Image" class="preview-image" aria-label="Recipe Preview Image">
        <?php endif; ?>

        <button type="submit" class="button" aria-label="Save Recipe Changes Button">Save Changes</button>
    </form>
</main>