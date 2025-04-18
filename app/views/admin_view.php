<?php require APP_DIR . '/views/head_view.php'; ?>
<?php require APP_DIR . '/views/header_view.php'; ?>

<div class="admin-dashboard">
    <h1 class="main-title">Admin Dashboard</h1>

    <section class="admin-section">
    <h2 class="secondary-title">My Account</h2>
        <p>Welcome, <?= htmlspecialchars($_SESSION['user']['username']) ?>!</p>
        <a href="logout" class="button">Log Out</a>
    </section>

    <section class="admin-section">
        <h2 class="secondary-title">Create New Recipe</h2>
        <form method="POST" action="admin" enctype="multipart/form-data" class="basic-form">
            <input type="hidden" name="action" value="create_recipe">
            
                <label>Recipe Image:</label>
                <input type="file" name="recipe_image" accept="image/*">
    
                <label>Title:</label>
                <input type="text" name="title" required>
           
                <label>Description:</label>
                <textarea name="description" required></textarea>
            
                <label>Ingredients:</label>
                <textarea name="ingredients" required></textarea>
           
                <label>Instructions:</label>
                <textarea name="instructions" required></textarea>

                <label>Cooking Time (minutes):</label>
                <input type="number" name="cooking_time" required>

                <label>Difficulty:</label>
                <select name="difficulty" required>
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

    <section class="admin-section">
        <h2 class="secondary-title">Manage Users</h2>
        <div class="user-list">
            <?php foreach ($users as $user): ?>
                <div class="user-item">
                    <span><?= htmlspecialchars($user['Username']) ?> (<?= htmlspecialchars($user['Email']) ?>)</span>
                    <a href="admin&delete=user&id=<?= $user['UserID'] ?>" 
                       class="button danger"
                       onclick="return confirm('Are you sure you want to delete this user?')">
                        Delete
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="admin-section">
        <h2 class="secondary-title">Manage Recipes</h2>
        <div class="recipe-list">
            <?php foreach ($recipes as $recipe): ?>
                <div class="recipe-item">
                    <?php if (!empty($recipe['ImageURL'])): ?>
                        <img src="public/<?= htmlspecialchars($recipe['ImageURL']) ?>" 
                            alt="<?= htmlspecialchars($recipe['Title']) ?>" 
                            class="recipe-thumbnail">
                    <?php endif; ?>
                    <h3><?= htmlspecialchars($recipe['Title']) ?></h3>
                    <p>By <?= htmlspecialchars($recipe['Author']) ?></p>
                    <a href="admin&delete=recipe&id=<?= $recipe['RecipeID'] ?>" 
                       class="button danger"
                       onclick="return confirm('Are you sure you want to delete this recipe?')">
                        Delete
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
</div>

<?php require APP_DIR . '/views/footer_view.php'; ?>