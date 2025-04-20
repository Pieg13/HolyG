document.addEventListener('DOMContentLoaded', function() {
    const burgerIcon = document.getElementById('burger-icon');
    const navLinks = document.getElementById('nav-links');
    const headerNav = document.getElementById('header-nav');

    // Toggle menu when burger icon is clicked
    burgerIcon.addEventListener('click', function() {
        navLinks.classList.toggle('open');
        
        // Add accessibility attributes
        const isExpanded = navLinks.classList.contains('open');
        burgerIcon.setAttribute('aria-expanded', isExpanded);
    });

    // Close the menu if clicked outside of it
    document.addEventListener('click', function(event) {
        const isClickInsideNav = headerNav.contains(event.target) || burgerIcon.contains(event.target);
        if (!isClickInsideNav) {
            navLinks.classList.remove('open');
            burgerIcon.setAttribute('aria-expanded', 'false');
        }
    });
});
