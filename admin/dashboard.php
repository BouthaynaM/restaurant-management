<?php
//includes database and auth_check to ensure user is logged in
require_once '../includes/auth_check.php';
require_once '../db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
            background:rgb(255, 170, 200);
            padding: 10px;
            margin-bottom: 20px;
        }
        .admin-nav ul {
            display: flex;
            list-style: none;
        }
        .admin-nav li {
            margin-right: this is the right margin
            margin-right: 15px;
        }
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-box {
            background: #f4f4f4;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
        }
        .stat-box h3 {
            margin-bottom: 10px;
        }
        .stat-number {
            font-size: 2rem;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1>Admin Dashboard</h1>
            <div>
                <!--displays logged in username-->
                <span>Welcome, <?php echo $_SESSION['username']; ?></span>
                <a href="logout.php" class="btn">Logout</a>
            </div>
        </div>
        
        <!--nav bar contains links to main admin sections-->
        <nav class="admin-nav">
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="menu_management.php">Menu Management</a></li>
                <li><a href="reservations.php">Reservations</a></li>
            </ul>
        </nav>
        

        <div class="stats-container">
            <!--three seperate queries to count different tables-->
            <!--fetch_assoc() gets the result as an array-->
            <?php
            //counts total nmber of items in the menu
            $menu_sql = "SELECT COUNT(*) as count FROM menu_items";
            $menu_result = $conn->query($menu_sql);
            $menu_count = $menu_result->fetch_assoc()['count'];
            
            //counts total reservations regardless of status
            $res_sql = "SELECT COUNT(*) as count FROM reservations";
            $res_result = $conn->query($res_sql);
            $res_count = $res_result->fetch_assoc()['count'];
            
            //counts pending reservations, result is stored in pending_count
            $pending_sql = "SELECT COUNT(*) as count FROM reservations WHERE status = 'pending'";
            $pending_result = $conn->query($pending_sql);
            $pending_count = $pending_result->fetch_assoc()['count'];
            ?>
            
            <div class="stat-box">
                <h3>Menu Items</h3>
                <div class="stat-number"><?php echo $menu_count; ?></div>
            </div>
            
            <div class="stat-box">
                <h3>Total Reservations</h3>
                <div class="stat-number"><?php echo $res_count; ?></div>
            </div>
            
            <div class="stat-box">
                <h3>Pending Reservations</h3>
                <div class="stat-number"><?php echo $pending_count; ?></div>
            </div>
        </div>
        
        <!--contains a table of the most recent reservations-->
        <div class="recent-activity">
            <h2>Recent Reservations</h2>
            <table width="100%" border="1" cellpadding="10" cellspacing="0">
                <tr>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Party Size</th>
                    <th>Status</th>
                </tr>
                <?php
                //database query gets all reservations records ordered by date, newest first
                //limits it to 5 most recent reservations
                $sql = "SELECT * FROM reservations ORDER BY reservation_date DESC LIMIT 5";
                $result = $conn->query($sql);
                
                //checks if any reservations exist
                if ($result->num_rows > 0) 
                {
                    //loops through each reservation 
                    while($row = $result->fetch_assoc()) 
                    {
                        //for each reservation, creates a table row with details
                        echo "<tr>";
                        echo "<td>" . $row['customer_name'] . "</td>";
                        echo "<td>" . $row['reservation_date'] . "</td>";
                        echo "<td>" . $row['reservation_time'] . "</td>";
                        echo "<td>" . $row['party_size'] . "</td>";
                        echo "<td>" . $row['status'] . "</td>";
                        echo "</tr>";
                    }
                } 
                else 
                {
                    //else displays no reservsations found
                    echo "<tr><td colspan='5'>No reservations found</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>