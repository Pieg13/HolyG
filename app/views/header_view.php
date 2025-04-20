<header>
    <nav id="header-nav">
        <div id="nav-group">
            <div id="logo-group">
                <a href="home">
                    <img src="public/images/avocado.svg" alt="avocado logo" aria-label="Avocado logo">
                    <p>HOLY GUACAMOLE</p>
                </a>
            </div>
            <button id="burger-icon" aria-label="Toggle menu">
                <img src="public/images/burger-menu.svg" alt="menu" aria-hidden="true">
            </button>
        </div>
        <ul id="nav-links">
            <li><a href="home" class="<?= $currentPage == 'home' ? 'active' : ''; ?>">HOME</a></li>          
            <li><a href="recipes" class="<?= $currentPage == 'recipes' ? 'active' : ''; ?>">RECIPES</a></li>
            <li><a href="about" class="<?= $currentPage == 'about' ? 'active' : ''; ?>">ABOUT</a></li>
            <li><a href="contact" class="<?= $currentPage == 'contact' ? 'active' : ''; ?>">CONTACT</a></li>
            <li><a href="<?= is_logged_in() ? (is_admin() ? 'admin' : 'user') : 'signin' ?>"
                class="<?= in_array($currentPage, ['signin', 'admin', 'user']) ? 'active' : '' ?>">
                <?= is_logged_in() ? (is_admin() ? 'ADMIN' : 'ACCOUNT') : 'SIGN IN' ?>
            </a></li>
        </ul>
    </nav>
</header>
<script type="module" src="public/js/burger_menu.js"></script>