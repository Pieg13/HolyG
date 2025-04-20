<header aria-label="Website Header">
    <nav id="header-nav" aria-label="Main Navigation">
        <div id="nav-group" aria-label="Navigation Group">
            <div id="logo-group" aria-label="Logo Section">
                <a href="home" aria-label="Home Page">
                    <img src="public/images/avocado.svg" alt="Avocado logo" aria-label="Avocado logo">
                    <p aria-label="Website Title">HOLY GUACAMOLE</p>
                </a>
            </div>
            <button id="burger-icon" aria-label="Toggle menu">
                <img src="public/images/burger-menu.svg" alt="Menu icon" aria-hidden="true">
            </button>
        </div>
        <ul id="nav-links" aria-label="Navigation Links">
            <li><a href="home" class="<?= $currentPage == 'home' ? 'active' : ''; ?>" aria-label="Home Page">HOME</a></li>          
            <li><a href="recipes" class="<?= $currentPage == 'recipes' ? 'active' : ''; ?>" aria-label="Recipes Page">RECIPES</a></li>
            <li><a href="about" class="<?= $currentPage == 'about' ? 'active' : ''; ?>" aria-label="About Page">ABOUT</a></li>
            <li><a href="contact" class="<?= $currentPage == 'contact' ? 'active' : ''; ?>" aria-label="Contact Page">CONTACT</a></li>
            <li>
                <a href="<?= is_logged_in() ? (is_admin() ? 'admin' : 'user') : 'signin' ?>"
                   class="<?= in_array($currentPage, ['signin', 'admin', 'user']) ? 'active' : '' ?>"
                   aria-label="<?= is_logged_in() ? (is_admin() ? 'Admin Dashboard' : 'User Account') : 'Sign In Page' ?>">
                    <?= is_logged_in() ? (is_admin() ? 'ADMIN' : 'ACCOUNT') : 'SIGN IN' ?>
                </a>
            </li>
        </ul>
    </nav>
</header>
<script type="module" src="public/js/burger_menu.js"></script>