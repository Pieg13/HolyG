<?php 
if (isset($_GET["action"]) && $_GET["action"] == "about") {
?>
<main>
<h1>About Us</h1>
    <div class="video-container">
        <video controls muted loop>
            <source src="public/video/mex-food.mp4">
        </video>
    </div>

<?php 
} 
?>

<div class="container">
    <h2>What is Holy Guacamole ?</h2>
    <p class="p-left">
        Welcome to Holy Guacamole—where every recipe tells a story, and every meal is a celebration!
        Holy Guacamole is more than just an expression—it's a celebration of Mexico’s rich culinary heritage, brought to life through authentic recipes passed down through generations. Our mission is simple: to share the true essence of Mexican cuisine, from vibrant street food to cherished family dishes, ensuring every bite is packed with tradition and flavor.
    </p>
    <p class="p-left">
        So grab your fresh ingredients, fire up the comal, and let’s make something truly delicioso.
    </p>
    <a class="button" href="recipes">Let's go!</a>
</div>