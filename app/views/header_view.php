<header>
    <nav id="headerNav">
        <!-- Avocado Logo -->
        <img src= "public/assets/images/avocado.svg" alt="avocado logo" aria-label="Avocado logo">
        <p>HOLY GUACAMOLE</p>
        
        <!-- Navigation Links -->
        <ul>
            <li><a href="?action=home" class="<?= $currentPage == 'home' ? 'active' : ''; ?>">HOME</a></li>          
            <li><a href="?action=recipes" class="<?= $currentPage == 'recipes' ? 'active' : ''; ?>">RECIPES</a></li>
            <li><a href="?action=about" class="<?= $currentPage == 'about' ? 'active' : ''; ?>">ABOUT</a></li>
            <li><a href="?action=contact" class="<?= $currentPage == 'contact' ? 'active' : ''; ?>">CONTACT</a></li>
            <li><a href="<?= isset($_SESSION['user']) ? '?action=logout' : '?action=signin'; ?>">
                <?= isset($_SESSION['user']) ? 'LOG OUT' : 'SIGN IN'; ?></a>
            </li>
        </ul>
        
        <!-- Burger Menu Icon (Mobile) -->
        <img src="public/assets/images/burger-menu.svg" alt="burger menu logo" aria-label="Menu">
    </nav>
</header>