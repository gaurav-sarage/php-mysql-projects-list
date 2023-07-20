<?php

    class User {

        public $db;

        public function __construct()
        {
            $db = new DB;
            $this->db = $db->connect();
        }

        public function emailExist($email) {
            $statement = $this->db->prepare("SELECT * FROM `users` WHERE `email` = :email");

            $statement->bindParam(":email", $email, PDO::PARAM_STR);

            $statement->execute();

            $user = $statement->fetch(PDO::FETCH_OBJ);

            if (!empty($user)) {
                return $user;
            }else {
                return false;
            }
        }

        public function hash($password) {
            return password_hash($password, PASSWORD_DEFAULT);
        }

        public function redirect($location) {
            header("Location: ".BASE_URL.$location);
        }
    }

?>