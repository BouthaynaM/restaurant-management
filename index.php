<?php
//includes the database connection file and the header file
require_once 'db_connect.php';
include 'includes/header.php';
?>

<!--displaying welcome banner with a call to action button-->
<section class="hero">
    <h2>Welcome to Our Restaurant</h2>
    <p>Enjoy the finest dining experience in town</p>
    <a href="reservation.php" class="btn">Make a Reservation</a>
</section>


<section class="featured">
    <h2>Featured Dishes</h2>
    <div class="dishes">
        <?php
        //running an sql query to get menu items marked as featured
        //using a join to get the category name from categories table in my database, and limiting it to 3 items
        $sql = "SELECT m.*, c.name as category_name 
                FROM menu_items m
                JOIN categories c ON m.category_id = c.category_id 
                WHERE m.featured = 1 
                LIMIT 3";
        $result = $conn->query($sql);

        //looping through the result and displaying each dish with name,description,price and category
        if ($result->num_rows > 0) 
        {
            while($row = $result->fetch_assoc()) 
            {
                echo "<div class='dish'>";
                echo "<h3>" . $row['name'] . "</h3>";
                echo "<p>" . $row['description'] . "</p>";
                echo "<span class='price'>$" . $row['price'] . "</span>";
                echo "<span class='category'>" . $row['category_name'] . "</span>";
                echo "</div>";
            }
        } else 
        {
            //showing message if no feature dishes are found
            echo "<p>No featured dishes available.</p>";
        }
        ?>
    </div>
</section>
<!-- including footer at end-->
<?php include 'includes/footer.php'; ?>