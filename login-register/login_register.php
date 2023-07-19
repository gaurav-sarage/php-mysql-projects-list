<?php 

require('connection.php');

if (isset($_POST['register']))
{
    $user_exist_query = "SELECT * FROM `registered_users` WHERE `usrname` = '$_POST[username]' OR `email` = '$_POST[email]'";

    $result = mysqli_query($conn, $user_exist_query);

    if ($result) {

    }
    else {
        
    }
}


?>