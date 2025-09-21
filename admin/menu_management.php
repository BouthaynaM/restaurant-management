<!-- this is the menu management page-->
<?php
//including database and auth_check for ensuring only logged in users access the page
require_once '../includes/auth_check.php';
require_once '../db_connect.php';

//message variable for user feedback
$message = '';

//for form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    
    //checking if add item form was submitted
    if (isset($_POST['add_item'])) 
    {
        //puts all form fields into variables
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $featured = isset($_POST['featured']) ? 1 : 0;
        
        //inserts the menu item into the menu_item table
        $sql = "INSERT INTO menu_items (name, description, price, category_id, featured) 
                VALUES ('$name', '$description', $price, $category, $featured)";
        
        //if it was successsful
        if ($conn->query($sql) === TRUE) 
        {
            //display success messages
            $message = '<div class="success">Menu item added successfully!</div>';
        } 
        else 
        {
            //else display error message
            $message = '<div class="error">Error: ' . $conn->error . '</div>';
        }
    }
    
    //checking if update_item form was submitted
    if (isset($_POST['update_item'])) 
    {
        //puts all form fields into variables
        $id = $_POST['item_id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $featured = isset($_POST['featured']) ? 1 : 0;
        
        //updates the menu item and includes item_id in the WHERE to update specific item
        $sql = "UPDATE menu_items SET 
                name = '$name', 
                description = '$description', 
                price = $price, 
                category_id = $category, 
                featured = $featured 
                WHERE item_id = $id";
        
        //if it was successful
        if ($conn->query($sql) === TRUE) 
        {
            //displays success message
            $message = '<div class="success">Menu item updated successfully!</div>';
        } 
        else 
        {
            //else displays error message
            $message = '<div class="error">Error: ' . $conn->error . '</div>';
        }
    }
    
    //checking if delete_item form was submitted
    if (isset($_POST['delete_item'])) 
    {
        //putting form field into variable
        $id = $_POST['item_id'];
        
        //using delete sql statement with where to get item_id
        $sql = "DELETE FROM menu_items WHERE item_id = $id";
        
        //if it was successful
        if ($conn->query($sql) === TRUE) 
        {
            //displays success message
            $message = '<div class="success">Menu item deleted successfully!</div>';
        } 
        else 
        {
            //else displays error message
            $message = '<div class="error">Error: ' . $conn->error . '</div>';
        }
    }
}

//checking url for edit_id parameter
$edit_item = null;
if (isset($_GET['edit_id'])) 
{
    $edit_id = $_GET['edit_id'];
    //queries database for that specific menu item
    $sql = "SELECT * FROM menu_items WHERE item_id = $edit_id";
    $result = $conn->query($sql);
    
    if ($result->num_rows == 1) 
    {
        //stores item data in edit_item variable for use in form
        $edit_item = $result->fetch_assoc();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Management</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .admin-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .admin-nav {
            background:rgb(255, 169, 205);
            padding: 10px;
            margin-bottom: 20px;
        }
        .admin-nav ul {
            display: flex;
            list-style: none;
        }
        .admin-nav li {
            margin-right: 15px;
        }
        .success {
            background-color: #dff0d8;
            color: #3c763d;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .error {
            background-color: #f2dede;
            color: #a94442;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .form-container, .items-container {
            background: #f9f9f9;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 5px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="number"], textarea, select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        .action-buttons form {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1>Menu Management</h1>
            <div>
                <span>Welcome, <?php echo $_SESSION['username']; ?></span>
                <a href="logout.php" class="btn">Logout</a>
            </div>
        </div>
        
        <nav class="admin-nav">
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="menu_management.php">Menu Management</a></li>
                <li><a href="reservations.php">Reservations</a></li>
            </ul>
        </nav>
        
        <?php echo $message; ?>
        
        <!-- edit and add form-->
        <div class="form-container">
            <h2><?php echo $edit_item ? 'Edit Menu Item' : 'Add New Menu Item'; ?></h2>
            
            <!--form checks if edit_item is set-->
            <form method="POST" action="">
                <?php if ($edit_item): ?>
                    <!--if set, form shows edit menu item and populates field with existing values-->
                    <input type="hidden" name="item_id" value="<?php echo $edit_item['item_id']; ?>">
                <?php endif; ?>
                
                <!--form for the adding and editing menu item-->
                <div class="form-group">
                    <label for="name">Item Name *</label>
                    <input type="text" id="name" name="name" required value="<?php echo $edit_item ? $edit_item['name'] : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="3"><?php echo $edit_item ? $edit_item['description'] : ''; ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="price">Price *</label>
                    <input type="number" id="price" name="price" step="0.01" required value="<?php echo $edit_item ? $edit_item['price'] : ''; ?>">
                </div>
                
                <!--wraps the form field for styling purposes-->
                <div class="form-group">
                    <!--creating a label thats associated with the dropdown-->
                    <!--for category connects it to the select element with id cateogry-->
                    <label for="category">Category *</label>

                    <!--creating the dropdown menu-->
                    <!--name vategory used in the POST when form is submitted-->
                    <select id="category" name="category" required>
                        <!--first option in the dropdown-->
                        <option value="">Select Category</option>
                        <?php
                        //query to get all categories ordered alphabeticlly by name
                        $cat_sql = "SELECT * FROM categories ORDER BY name";
                        //executes the query
                        $cat_result = $conn->query($cat_sql);
                        
                        //ensures there are categories to display
                        if ($cat_result->num_rows > 0) 
                        {
                            //processes each category row
                            //cat becomes an array containing the current rows data
                            while($cat = $cat_result->fetch_assoc()) 
                            {
                                //if were in edit mode and the current category id matches items category id
                                //then set selected to the string selected otherwise leave it empty
                                $selected = ($edit_item && $edit_item['category_id'] == $cat['category_id']) ? 'selected' : '';
                                //creating an option element for each category
                                echo "<option value='" . $cat['category_id'] . "' $selected>" . $cat['name'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="featured">
                        <!--create checkbox element, featured will appear in the POST array when form is submitted-->
                        <!--if in edit mode and featured value in data base is 1, then output string checked, otherwise nothing-->
                        <!--so that when editing an item, the checkbox is pre checked if item is marked as featured-->
                        <input type="checkbox" id="featured" name="featured" <?php echo ($edit_item && $edit_item['featured'] == 1) ? 'checked' : ''; ?>>
                        Featured Item
                    </label>
                </div>
                
                <!--checks if were in edit mode, determines what btn to show-->
                <!--when editing existing btn, 2 btns are shown-->
                <?php if ($edit_item): ?>
                    
                    <!--this is submit button that triggers form submission-->
                    <button type="submit" name="update_item" class="btn">Update Item</button>
                    <!-- cancel, links back to menu_management which exits edit mode-->
                    <a href="menu_management.php" class="btn" style="background-color: #ccc;">Cancel Edit</a>
                <?php else: ?>
                    <!--when were adding, only add btn is shown, this is submit button for adding a new item-->
                    <button type="submit" name="add_item" class="btn">Add Item</button>
                <?php endif; ?>
            </form>
        </div>
        
        <!--contains entire table section-->
        <div class="items-container">
            <h2>Menu Items</h2>
            
            <!--creating table to display menu items in a nice format-->
            <table>
                <!--contain the header row-->
                <thead>
                    <tr>
                        <!--define header cells with column titles-->
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Featured</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //selects all columns from menu_items table, selects category name
                    $sql = "SELECT m.*, c.name as category_name 
                            FROM menu_items m
                            /*joining to connect the categories on the cateogyr_id field*/
                            JOIN categories c ON m.category_id = c.category_id
                            ORDER BY m.name";
                    //executes the query and stores the result set
                    $result = $conn->query($sql);
                    
                    //checks if any results were found
                    if ($result->num_rows > 0) 
                    {
                        //if results exist, loops through each row
                        //creates a table row for each menu item
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['item_id'] . "</td>";
                            echo "<td>" . $row['name'] . "</td>";
                            echo "<td>" . substr($row['description'], 0, 50) . (strlen($row['description']) > 50 ? '...' : '') . "</td>";
                            echo "<td>$" . $row['price'] . "</td>";
                            echo "<td>" . $row['category_name'] . "</td>";
                            echo "<td>" . ($row['featured'] ? 'Yes' : 'No') . "</td>";
                            echo "<td class='action-buttons'>";
                            //edit button
                            echo "<a href='menu_management.php?edit_id=" . $row['item_id'] . "' class='btn'>Edit</a>";
                            //delete button
                            echo "<form method='POST' action='' onsubmit='return confirm(\"Are you sure you want to delete this item?\")'>";
                            echo "<input type='hidden' name='item_id' value='" . $row['item_id'] . "'>";
                            echo "<button type='submit' name='delete_item' class='btn' style='background-color: #d9534f;'>Delete</button>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } 
                    else 
                    {
                        //display no menu items found
                        echo "<tr><td colspan='7'>No menu items found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>