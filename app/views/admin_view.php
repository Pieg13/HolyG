<?php require APP_DIR . '/views/head_view.php'; ?>
<?php require APP_DIR . '/views/header_view.php'; ?>

<main>
    <h1>Admin Dashboard</h1>

    <section class="container">
    <h2>My Account</h2>
        <p>Welcome, <?= htmlspecialchars($_SESSION['user']['username']) ?>!</p>
        <a href="logout" class="button">Log Out</a>
    </section>

    <section class="container">
        <h2>Create New Recipe</h2>
        <form method="POST" action="admin" enctype="multipart/form-data" class="basic-form">
    <input type="hidden" name="action" value="create_recipe">

    <label for="recipe_image">Recipe Image:</label>
    <input type="file" name="recipe_image" id="recipe_image" accept="image/*">

    <label for="title">Title:</label>
    <input type="text" name="title" id="title" required>

    <label for="description">Description:</label>
    <textarea name="description" id="description" required></textarea>

    <label for="ingredients">Ingredients:</label>
    <textarea name="ingredients" id="ingredients" required></textarea>

    <label for="instructions">Instructions:</label>
    <textarea name="instructions" id="instructions" required></textarea>

    <label for="cooking_time">Cooking Time (minutes):</label>
    <input type="number" name="cooking_time" id="cooking_time" required>

    <label for="difficulty">Difficulty:</label>
    <select name="difficulty" id="difficulty" required>
        <option value="Easy">Easy</option>
        <option value="Medium">Medium</option>
        <option value="Hard">Hard</option>
    </select>

    <button type="submit" class="button">Publish Recipe</button>
</form>
    </section>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert success"><?= htmlspecialchars($_SESSION['success']) ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert error"><?= htmlspecialchars($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <section class="container">
        <h2>Manage Users</h2>
        <div class="user-list">
            <?php foreach ($users as $user): ?>
                    <span><?= htmlspecialchars($user['Username']) ?> (<?= htmlspecialchars($user['Email']) ?>)</span>
                    <a href="admin&delete=user&id=<?= $user['UserID'] ?>" 
                       class="danger button"
                       onclick="return confirm('Are you sure you want to delete this user?')">
                        Delete
                    </a>
            <?php endforeach; ?>
        </div>
    </section>

    <h2>Manage Recipes</h2>
    <div class="recipes-grid">
        <?php if (empty($recipes)): ?>
            <p class="no-recipes">No recipes found!</p>
        <?php else: ?>
            <?php foreach ($recipes as $recipe): ?>
                <div class="recipe-card">
                    <div class="image-container">
                        <img src="public/<?= !empty($recipe['ImageURL']) ? htmlspecialchars($recipe['ImageURL']) : 'images/avocado.svg' ?>" alt="<?= htmlspecialchars($recipe['Title']) ?>">
                    </div>

                    <h3><?= htmlspecialchars($recipe['Title']) ?></h3>
                    <p>By <?= htmlspecialchars($recipe['Author']) ?></p>
                    <!-- Edit Button -->
                    <a href="admin&edit=recipe&id=<?= $recipe['RecipeID'] ?>" class="button">Edit</a>
                    <!-- Delete Button -->
                    <a href="admin&delete=recipe&id=<?= $recipe['RecipeID'] ?>" class="button danger" onclick="return confirm('Are you sure you want to delete this recipe?')">Delete</a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

<?php require APP_DIR . '/views/footer_view.php'; ?>