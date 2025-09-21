<!--this page is to display information about the resturuant-->
<?php
//includes the database and the header
require_once 'db_connect.php';
include 'includes/header.php';
?>

<!--creating a structured about page with header section and tagline-->
<section class="about-page">
    <div class="about-header">
        <h2>About Our Restaurant</h2>
        <p class="tagline">A culinary journey that began in 2010</p>
    </div>
    
    <!--information about the chef and a mini biography-->
    <div class="about-content">
        <div class="about-text">
            <h3>Our Story</h3>
            <p>Founded by Chef Madoka in 2010, our restaurant has been serving the community with passion and dedication for over a decade. What started as a small family business has grown into one of the city's most beloved dining destinations.</p>
            
            <p>We believe in using only the freshest ingredients, sourced locally whenever possible. Our menu changes seasonally to reflect the best produce available, ensuring that every dish is at its peak flavor.</p>
            
            <h3>Our Philosophy</h3>
            <p>At our restaurant, we believe that dining is more than just eating—it's an experience that should engage all the senses. From the moment you step through our doors, you'll be immersed in a warm and inviting atmosphere designed to complement our exceptional cuisine.</p>
            
            <p>We are committed to sustainable practices and supporting local farmers and producers. By building relationships with our suppliers, we ensure that our ingredients are not only delicious but also responsibly sourced.</p>
        </div>
        
        <div class="chef-section">
            <h3>Meet Our Chef</h3>
            <div class="chef-info">
                <div class="chef-image">
                <img src="images/chef.jpeg" alt="Chef Michael Rodriguez" class="chef-photo" width="250">
                </div>
                <div class="chef-bio">
                    <h4>Chef Madoka</h4>
                    <p>With over 20 years of culinary experience, Chef Miadoka brings a unique perspective to every dish. After training in Paris and working in Michelin-starred restaurants across Europe, he returned to his hometown to create a dining experience that combines international techniques with local flavors.</p>
                    <p>Chef Madoka's innovative approach has earned the restaurant numerous accolades, including "Best Fine Dining" three years in a row.</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="testimonials">
        <h3>What Our Customers Say</h3>
        <div class="testimonial-grid">
            <div class="testimonial">
                <p>"The best dining experience I've had in years. Every dish was perfect!"</p>
                <span class="customer">— Bou</span>
            </div>
            <div class="testimonial">
                <p>"The attention to detail is remarkable. From the service to the food, everything was exceptional."</p>
                <span class="customer">— Homura</span>
            </div>
            <div class="testimonial">
                <p>"A hidden gem! The seasonal menu keeps me coming back to discover new favorites."</p>
                <span class="customer">— Sara</span>
            </div>
        </div>
    </div>
</section>

<!-- including the footer-->
<?php include 'includes/footer.php'; ?>