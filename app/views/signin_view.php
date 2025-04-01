<body>
    <h1>Sign In</h1>

    <form action="?action=signup_process" method="POST">

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Sign In</button>

        <p>Don't have an account? <a href="?action=signup">Sign up</a></p>
    </form>
</body>
</html>