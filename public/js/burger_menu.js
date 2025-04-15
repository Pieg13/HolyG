document.addEventListener('DOMContentLoaded', function() {
    const burgerIcon = document.getElementById('burger-icon');
    const navLinks = document.getElementById('nav-links');
    
    // Toggle menu when burger icon is clicked
    burgerIcon.addEventListener('click', function() {
        navLinks.classList.toggle('open');
        
        // Add accessibility attributes
        const isExpanded = navLinks.classList.contains('open');
        burgerIcon.setAttribute('aria-expanded', isExpanded);
    });
    
    // Close menu when clicking outside navigation
    document.addEventListener('click', function(event) {
        const isClickInsideNav = headerNav.contains(event.target);
        
        if (!isClickInsideNav && navLinks.classList.contains('open')) {
            navLinks.classList.remove('open');
            burgerIcon.setAttribute('aria-expanded', false);
        }
    });
    
    // Close menu when window is resized to desktop
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 768 && navLinks.classList.contains('open')) {
            navLinks.classList.remove('open');
            burgerIcon.setAttribute('aria-expanded', false);
        }
    });
});