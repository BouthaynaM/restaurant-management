<?php
session_start();

//checking if user is logged in
if (!isset($_SESSION['user_id'])) 
{
    //if not logged in, redirect to homepage
    header("Location: login.php");
    exit;
}
?>