<?php
//initialising the php session
//this is used to track logged in users across pages
session_start();
//including the database
require_once '../db_connect.php';

//checking if the user_id sessin variable exists
if(isset($_SESSION['user_id'])) 
{
    //redirects to dashboard
    header("Location: dashboard.php");
    exit;
}

//checking if the form was submitted by POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    //getting the username and password from form
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    //creating an sql query to find the user with a matching username
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);
    
    //checking if exactly 1 user was found
    if ($result->num_rows == 1) 
    {
        //if found, gets full user record with fetch_assoc
        $user = $result->fetch_assoc();

        //comparing pasword directly
        if ($password == $user['password']) 
        {
            //if passwords match, setting session variables
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            
            //redirects to dashboard 
            header("Location: dashboard.php");
            exit;
        } 
        else 
        {
            //if password doesnt match
            $error = "Invalid password";
        }
    } 
    else 
    {
        //if username doesnt exist
        $error = "User not found";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .login-form 
        {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form-group 
        {
            margin-bottom: 15px;
        }
        label 
        {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="password"] 
        {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .error 
        {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <!--form with username and password fields-->
    <div class="login-form">
        <h2>Admin Login</h2>
        
        <!--display any error messages at top-->
        <?php if(isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <!--submitted to the same page-->
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn">Login</button>
        </form>
        
        <!--link back to homepage-->
        <p><a href="../index.php">Back to Homepage</a></p>
    </div>
</body>
</html>