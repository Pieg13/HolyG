<?php 
if (isset($_GET["action"]) && $_GET["action"] == "about") {
?>

<h1 class="main-title">About Us</h1>
    <div class="video-container">
        <video autoplay muted loop>
            <source src="public/video/mex-food.mp4">
        </video>
    </div>

<?php 
} 
?>

<div id="about-section">
    <h2 class="secondary-title">What is Holy Guacamole ?</h2>
    <p class="basic-text">
        Welcome to Holy Guacamole—where every recipe tells a story, and every meal is a celebration!
        Holy Guacamole is more than just an expression—it's a celebration of Mexico’s rich culinary heritage, brought to life through authentic recipes passed down through generations. Our mission is simple: to share the true essence of Mexican cuisine, from vibrant street food to cherished family dishes, ensuring every bite is packed with tradition and flavor.
    </p>
    <p class="basic-text">
        So grab your fresh ingredients, fire up the comal, and let’s make something truly delicioso.
    </p>
    <a class="call-to-action" href="?action=recipes">Let's go!</a>
</div>