<?php require APP_DIR . '/views/head_view.php'; ?>
<?php require APP_DIR . '/views/header_view.php'; ?>

<main aria-label="Admin Dashboard">
    <h1 aria-label="Dashboard Title">Admin Dashboard</h1>

    <section class="container" aria-label="User Account Section">
        <h2 aria-label="Account Section Title">My Account</h2>
        <p aria-label="User Greeting">Welcome, <?= htmlspecialchars($_SESSION['user']['username']) ?>!</p>
        <a href="logout" class="button" aria-label="Logout Button">Log Out</a>
    </section>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert success" aria-label="Success Message"><?= htmlspecialchars($_SESSION['success']) ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert error-p" aria-label="Error Message"><?= htmlspecialchars($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <section class="container" aria-label="Recipe Creation Section">
        <h2 aria-label="Create Recipe Section Title">Create New Recipe</h2>
        <form method="POST" action="admin" enctype="multipart/form-data" class="basic-form" aria-label="Recipe Form">
            <input type="hidden" name="action" value="create_recipe">

            <label for="recipe_image">Recipe Image:</label>
            <input type="file" name="recipe_image" id="recipe_image" accept="image/*" aria-label="Upload Recipe Image">

            <label for="title">Title:</label>
            <input type="text" name="title" id="title" required aria-label="Recipe Title">

            <label for="description">Description:</label>
            <textarea name="description" id="description" required aria-label="Recipe Description"></textarea>

            <label for="ingredients">Ingredients:</label>
            <textarea name="ingredients" id="ingredients" required aria-label="Recipe Ingredients"></textarea>

            <label for="instructions">Instructions:</label>
            <textarea name="instructions" id="instructions" required aria-label="Recipe Instructions"></textarea>

            <label for="cooking_time">Cooking Time (minutes):</label>
            <input type="number" name="cooking_time" id="cooking_time" required aria-label="Cooking Time Input">

            <label for="difficulty">Difficulty:</label>
            <select name="difficulty" id="difficulty" required aria-label="Select Difficulty Level">
                <option value="Easy">Easy</option>
                <option value="Medium">Medium</option>
                <option value="Hard">Hard</option>
            </select>

            <button type="submit" class="button" aria-label="Publish Recipe Button">Publish Recipe</button>
        </form>
    </section>

    <section class="container" aria-label="User Management Section">
        <h2 aria-label="Manage Users Section Title">Manage Users</h2>
        <div class="user-list">
            <?php foreach ($users as $user): ?>
                <span aria-label="User Info"><?= htmlspecialchars($user['Username']) ?> (<?= htmlspecialchars($user['Email']) ?>)</span>
                <a href="admin&delete=user&id=<?= $user['UserID'] ?>" class="danger button" 
                   onclick="return confirm('Are you sure you want to delete this user?')" 
                   aria-label="Delete User Button">
                    Delete
                </a>
            <?php endforeach; ?>
        </div>
    </section>

    <h2 aria-label="Manage Recipes Section Title">Manage Recipes</h2>
    <div class="recipes-grid" aria-label="Recipes Grid">
        <?php if (empty($recipes)): ?>
            <p class="no-recipes" aria-label="No Recipes Message">No recipes found!</p>
        <?php else: ?>
            <?php foreach ($recipes as $recipe): ?>
                <div class="recipe-card" aria-label="Recipe Card">
                    <div class="image-container" aria-label="Recipe Image">
                        <img src="public/<?= !empty($recipe['ImageURL']) ? htmlspecialchars($recipe['ImageURL']) : 'images/avocado.svg' ?>" 
                             alt="<?= htmlspecialchars($recipe['Title']) ?>">
                    </div>

                    <h3 aria-label="Recipe Title"><?= htmlspecialchars($recipe['Title']) ?></h3>
                    <p aria-label="Recipe Author">By <?= htmlspecialchars($recipe['Author']) ?></p>
                    
                    <a href="admin&edit=recipe&id=<?= $recipe['RecipeID'] ?>" class="button" aria-label="Edit Recipe Button">Edit</a>
                    <a href="admin&delete=recipe&id=<?= $recipe['RecipeID'] ?>" class="button danger" 
                       onclick="return confirm('Are you sure you want to delete this recipe?')" 
                       aria-label="Delete Recipe Button">
                        Delete
                    </a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

<?php require APP_DIR . '/views/footer_view.php'; ?>