<!--this will display all my menu items organized by categories-->
<?php
//im including my database and the header
require_once 'db_connect.php';
include 'includes/header.php';
?>
<!--main heading for menu-->
<section class="menu-page">
    <h2 class="section-header">Our Menu</h2>
    
    <div class="menu-container">
        <?php
        //running a query to get all the categories ordered by name
        $sql = "SELECT * FROM categories ORDER BY name";
        $result = $conn->query($sql);
        
        //for each category it displays the name as a heading
        if ($result->num_rows > 0) 
        {
            while($category = $result->fetch_assoc()) 
            {
                echo "<div class='menu-category'>";
                echo "<h3>" . $category['name'] . "</h3>";
                
                //running a query to get all menu items in that category
                $items_sql = "SELECT * FROM menu_items WHERE category_id = " . $category['category_id'] . " ORDER BY name";
                $items_result = $conn->query($items_sql);
                
                //here im displaying each menu item with its name, description and its price
                if ($items_result->num_rows > 0) 
                {
                    echo "<div class='menu-items-list'>";
                    while($item = $items_result->fetch_assoc()) 
                    {
                        echo "<div class='menu-item'>";
                        echo "<div class='menu-item-info'>";
                        echo "<h4>" . $item['name'] . "</h4>";
                        echo "<p class='menu-item-desc'>" . $item['description'] . "</p>";
                        echo "</div>";
                        echo "<div class='menu-item-price'>$" . number_format($item['price'], 2) . "</div>";
                        echo "</div>";
                    }
                    echo "</div>";
                } else 
                {
                    //displaying message if there isnt any items in that category
                    echo "<p>No items in this category.</p>";
                }
                
                echo "</div>";
            }
        } else 
        {
            //displaying this message if there are no categories found
            echo "<p>No categories found.</p>";
        }
        ?>
    </div>
</section>

<!--including the footer-->
<?php include 'includes/footer.php'; ?>