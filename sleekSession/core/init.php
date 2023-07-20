<?php

    session_start();

    require 'classes/DB.php';
    require 'classes/User.php';

    $userObj = new User;

    define('BASE_URL', 'http://localhost/sleekSession/');

?>
