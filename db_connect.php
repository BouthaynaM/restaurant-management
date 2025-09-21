<!--this is connecting my database-->
<?php


    $db_server = "localhost";
    $db_user = "root";
    $db_pass = '';
    $db_name = "resturauntdb";
    $conn = "";

    $conn = mysqli_connect($db_server,$db_user,$db_pass,$db_name);

    //if($conn)
    //{
    //    echo"you are connected!!>//< <br> hehehehehhe";
    //}
    //else{
    //    echo"could not connect";
    //}


?>