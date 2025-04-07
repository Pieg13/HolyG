<header>
    <nav id="headerNav">
        <div id="nav-group">
            <div id="logo-group">
                <img src= "public/images/avocado.svg" alt="avocado logo" aria-label="Avocado logo">
                <p>HOLY GUACAMOLE</p>
            </div>
            <img src="public/images/burger-menu.svg" alt="burger menu logo" aria-label="Menu" id='burger-icon'>
        </div>
        <!-- Navigation Links -->
        <ul id="nav-links">
            <li><a href="?action=home" class="<?= $currentPage == 'home' ? 'active' : ''; ?>">HOME</a></li>          
            <li><a href="?action=recipes" class="<?= $currentPage == 'recipes' ? 'active' : ''; ?>">RECIPES</a></li>
            <li><a href="?action=about" class="<?= $currentPage == 'about' ? 'active' : ''; ?>">ABOUT</a></li>
            <li><a href="?action=contact" class="<?= $currentPage == 'contact' ? 'active' : ''; ?>">CONTACT</a></li>
            <li><a href="<?= isset($_SESSION['user']) ? '?action=logout' : '?action=signin'; ?>">
                <?= isset($_SESSION['user']) ? 'LOG OUT' : 'SIGN IN'; ?></a>
            </li>
        </ul>
        
    </nav>
</header>
<script src="public/js/burger_menu.js"></script>