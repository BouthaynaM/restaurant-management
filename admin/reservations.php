<!--this is for the reservations page in admin section-->
<?php
//including the database and the auth_check to ensure authenticated users only
require_once '../includes/auth_check.php';
require_once '../db_connect.php';

//variable to hold messages for user
$message = '';

//checks if the form was submitted by POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    
    //code here handles 2 possible actions
    //updating and deleting reservations

    //checks if the status update form was submitted
    if (isset($_POST['update_status'])) 
    {
        //gets the reservation id and the new status from the form data
        $id = $_POST['reservation_id'];
        $status = $_POST['status'];
        
        //executes and update query to update the table
        $sql = "UPDATE reservations SET status = '$status' WHERE reservation_id = $id";
        
        //checks if it was successfull
        if ($conn->query($sql) === TRUE) 
        {
            //displays success message
            $message = '<div class="success">Reservation status updated successfully!</div>';
        } 
        else 
        {
            //displayed error message
            $message = '<div class="error">Error: ' . $conn->error . '</div>';
        }
    }
    
    //checks if the delete form was submitted
    if (isset($_POST['delete_reservation'])) 
    {
        //gets the reservation id from the form data
        $id = $_POST['reservation_id'];
        
        //executes a delete sql query
        $sql = "DELETE FROM reservations WHERE reservation_id = $id";
        
        //checks if it was successful
        if ($conn->query($sql) === TRUE) 
        {
            //displays success messages
            $message = '<div class="success">Reservation deleted successfully!</div>';
        } 
        else 
        {
            //displays error message
            $message = '<div class="error">Error: ' . $conn->error . '</div>';
        }
    }
}

//gets the status filter from the url
$status_filter = isset($_GET['status']) ? $_GET['status'] : 'all';

// starts with base query to select all reservations
$query = "SELECT * FROM reservations";
//if a specific status filter is active, adds a where
if ($status_filter != 'all') 
{
    $query .= " WHERE status = '$status_filter'";
}
//adds order by to sort by reservation date, newest first
$query .= " ORDER BY reservation_date DESC";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Reservations</title>
    <!--linking style sheet-->
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
            background:rgb(255, 170, 223);
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
        .filter-container {
            margin-bottom: 20px;
        }
        .filter-container select {
            padding: 5px;
            margin-right: 10px;
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
        .status-pending {
            color: #856404;
            background-color: #fff3cd;
            padding: 3px 8px;
            border-radius: 3px;
        }
        .status-confirmed {
            color: #155724;
            background-color: #d4edda;
            padding: 3px 8px;
            border-radius: 3px;
        }
        .status-cancelled {
            color: #721c24;
            background-color: #f8d7da;
            padding: 3px 8px;
            border-radius: 3px;
        }
        .status-completed {
            color: #0c5460;
            background-color: #d1ecf1;
            padding: 3px 8px;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <!--main container for admin interface-->
    <div class="admin-container">
        <div class="admin-header">
            <h1>Manage Reservations</h1>
            <div>
                <!--welcome message showing the logged in username-->
                <span>Welcome, <?php echo $_SESSION['username']; ?></span>
                <!--logout button linking to logout.php-->
                <a href="logout.php" class="btn">Logout</a>
            </div>
        </div>
        
        <!--navigation menu with links to other admin sections-->
        <nav class="admin-nav">
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="menu_management.php">Menu Management</a></li>
                <li><a href="reservations.php">Reservations</a></li>
            </ul>
        </nav>
        
        <!--output any success or error messages-->
        <?php echo $message; ?>
        
        <!--holds the filtering interface for viewing reservation by status-->
        <div class="filter-container">
            <!--uses get method which adds parameters to the url-->
            <form method="GET" action="">
                <!--status drop down, allows filtering reservations by status-->
                <label for="status">Filter by Status:</label>
                <!--automatically submits form when a different status is selected-->
                <select id="status" name="status" onchange="this.form.submit()">
                    <!--each option has a conditional that adds selected if it matches current filter-->
                    <option value="all" <?php echo $status_filter == 'all' ? 'selected' : ''; ?>>All Reservations</option>
                    <option value="pending" <?php echo $status_filter == 'pending' ? 'selected' : ''; ?>>Pending</option>
                    <option value="confirmed" <?php echo $status_filter == 'confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                    <option value="cancelled" <?php echo $status_filter == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                    <option value="completed" <?php echo $status_filter == 'completed' ? 'selected' : ''; ?>>Completed</option>
                </select>
            </form>
        </div>
        
        <!--reservations table with 9 columns-->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Guests</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //executes query built earlier
                $result = $conn->query($query);
                
                //checks if any reservations were found
                if ($result->num_rows > 0) 
                {
                    //loops through each reservation
                    while($row = $result->fetch_assoc()) 
                    {
                        //for each reservation, creates a table row with details
                        //creates css class now based on status
                        $status_class = "status-" . $row['status'];
                        
                        echo "<tr>";
                        echo "<td>" . $row['reservation_id'] . "</td>";
                        echo "<td>" . $row['customer_name'] . "</td>";
                        echo "<td>" . $row['reservation_date'] . "</td>";
                        echo "<td>" . $row['reservation_time'] . "</td>";
                        echo "<td>" . $row['party_size'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['phone'] . "</td>";
                        //status is displayed with different background color based on status, defined in css
                        //first letter capitilised using ucfirst()
                        echo "<td><span class='" . $status_class . "'>" . ucfirst($row['status']) . "</span></td>";
                        //each reservation has 2 forms in the actions column, update and delete status
                        echo "<td class='action-buttons'>";
                        echo "<form method='POST' action=''>";
                        echo "<input type='hidden' name='reservation_id' value='" . $row['reservation_id'] . "'>";
                        echo "<select name='status'>";
                        echo "<option value='pending' " . ($row['status'] == 'pending' ? 'selected' : '') . ">Pending</option>";
                        echo "<option value='confirmed' " . ($row['status'] == 'confirmed' ? 'selected' : '') . ">Confirmed</option>";
                        echo "<option value='cancelled' " . ($row['status'] == 'cancelled' ? 'selected' : '') . ">Cancelled</option>";
                        echo "<option value='completed' " . ($row['status'] == 'completed' ? 'selected' : '') . ">Completed</option>";
                        echo "</select>";
                        echo "<button type='submit' name='update_status' class='btn'>Update</button>";
                        echo "</form>";
                        echo "<form method='POST' action='' onsubmit='return confirm(\"Are you sure you want to delete this reservation?\")'>";
                        echo "<input type='hidden' name='reservation_id' value='" . $row['reservation_id'] . "'>";
                        echo "<button type='submit' name='delete_reservation' class='btn' style='background-color: #d9534f;'>Delete</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } 
                else 
                {
                    //if no reservations match filter, shows all columns
                    echo "<tr><td colspan='9'>No reservations found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>