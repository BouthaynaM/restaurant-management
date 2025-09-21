<?php
//initialises session
session_start();
//destroys all data for the current session, essentially logs user out by removing all their authentication info
session_destroy();
//sends a http header to redirect the browser and redirects the user to the login page
header("Location: login.php");
exit;
?>