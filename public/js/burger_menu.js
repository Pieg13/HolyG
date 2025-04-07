document.addEventListener('DOMContentLoaded', function() {

    document.getElementById('burger-icon').addEventListener('click', function() {
        const navLinks = document.getElementById('nav-links');
        navLinks.classList.toggle('open');
    });
    
});