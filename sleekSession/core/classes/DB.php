<?php

    class DB{
        function connect() {
            $db = new PDO("mysql:host=127.0.0.1; dbname=sleeksession", "root", "");

            return $db;
        }
    }



?>