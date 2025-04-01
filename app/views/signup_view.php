<?php require APP_DIR . '/views/head_view.php'; ?>

<body>

    <h1>Sign Up</h1>

    <form action="register.php" method="POST" enctype="multipart/form-data">
        <h2>Register</h2>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required minlength="3" maxlength="50">

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required minlength="6">

        <label for="profilePicture">Profile Picture:</label>
        <input type="file" id="profilePicture" name="profilePicture" accept="image/*">

        <button type="submit">Sign Up</button>
    </form>

</body>