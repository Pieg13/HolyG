<?php 
if (isset($_GET["action"]) && $_GET["action"] == "about") {
?>
<main aria-label="About Us Section">
    <h1 aria-label="Page Title">About Us</h1>
    <div class="video-container" aria-label="Promotional Video">
        <video controls muted loop aria-label="Mexican Food Video">
            <source src="public/video/mex-food.mp4">
        </video>
    </div>
<?php 
} 
?>

<div class="container" aria-label="Introduction to Holy Guacamole">
    <h2 aria-label="Section Title">What is Holy Guacamole?</h2>
    <p class="p-left" aria-label="Introduction Paragraph">
        Welcome to Holy Guacamole—where every recipe tells a story, and every meal is a celebration!
        Holy Guacamole is more than just an expression—it's a celebration of Mexico’s rich culinary heritage, brought to life through authentic recipes passed down through generations. Our mission is simple: to share the true essence of Mexican cuisine, from vibrant street food to cherished family dishes, ensuring every bite is packed with tradition and flavor.
    </p>
    <p class="p-left" aria-label="Encouragement Paragraph">
        So grab your fresh ingredients, fire up the comal, and let’s make something truly delicioso.
    </p>
    <a class="button" href="recipes" aria-label="Explore Recipes">Let's go!</a>
</div>