<?php
    namespace MyApp;
    use PDO;
    class User {

        public $db, $userID, $sessionID;

        public function __construct()
        {
            $db = new \MyApp\DB;
            $this->db = $db->connect();
            $this->userID = $this->ID();
            $this->sessionID = $this->getSessionID();
        }

        public function ID() {
            if($this->isLoggedIn()){
                return $_SESSION['userID'];
            }
        }

        public function getSessionID() {
            return session_id();
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

        public function userData($userID = '') {
            $userID = ((!empty($userID)) ? $userID : $this->userID);
            $statement = $this->db->prepare("SELECT * FROM `users` WHERE `userID` = :userID");

            $statement->bindParam(":userID", $userID, PDO::PARAM_STR);

            $statement->execute();

            return $statement->fetch(PDO::FETCH_OBJ);
            
        }

        public function isLoggedIn() {
            return ((isset($_SESSION['userID'])) ? true: false);
        }

        public function logout() {
            $_SESSION = array();
            session_destroy();
            session_regenerate_id();
            $this->redirect('index.php');
        }

        public function getUsers() {
            $statement = $this->db->prepare("SELECT * FROM `users` WHERE `userID` != :userID");

            $statement->bindParam(":userID", $this->userID, PDO::PARAM_INT);

            $statement->execute();

            $users = $statement->fetchAll(PDO::FETCH_OBJ);

            foreach($users as $user) {
                echo '<li class="select-none transition     hover:bg-green-50 p-4 cursor-pointer select-none">
                    <a href="'.BASE_URL.$user->username.'">
                        <div class="user-box flex items-center flex-wrap">
                            <div class="flex-shrink-0 user-img w-14 h-14 rounded-full border overflow-hidden">
                                <img class="w-full h-full" src="'.BASE_URL.$user->profileImage.'">
                            </div>
                        <div class="user-name ml-2">
                        <div>
                            <span class="flex font-medium">
                            '.$user->name.'
                            </span>
                        </div>
                        <div></div>
                    </div>
                    </div>
                </a>
            </li>';
            }
        }

        public function getUserByUsername($username = '') {

            $statement = $this->db->prepare("SELECT * FROM `users` WHERE `username` = :username");

            $statement->bindParam(":username", $username, PDO::PARAM_STR);

            $statement->execute();

            return $statement->fetch(PDO::FETCH_OBJ);
            
        }

        public function updateSession() {
            $statement = $this->db->prepare("UPDATE `users` SET `sessionID` = :sessionID WHERE `userID` = :userID");

            $statement->bindParam(":sessionID", $this->sessionID, PDO::PARAM_STR);

            $statement->bindParam(":userID", $this->userID, PDO::PARAM_INT);

            $statement->execute();
        }

        public function getUserBySession($sessionID) {
            $statement = $this->db->prepare("SELECT * FROM `users` WHERE `sessionID` = :sessionID");

            $statement->bindParam(":sessionID", $sessionID, PDO::PARAM_STR);

            $statement->execute();

            return $statement->fetch(PDO::FETCH_OBJ);
        }

        public function updateConnection($connectionID, $userID) {
            $statement = $this->db->prepare("UPDATE `users` SET `connectionID` = :connectionID WHERE `userID` = :userID");

            $statement->bindParam(":connectionID", $connectionID, PDO::PARAM_STR);

            $statement->bindParam(":userID", $userID, PDO::PARAM_INT);

            $statement->execute();
        }

    }

?>