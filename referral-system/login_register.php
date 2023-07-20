<?php 

require('connection.php');
session_start();

function updateReferral() {
    $query = "SELECT * FROM `registered_users` WHERE `referral_code` = '$_POST[refcode]'";

    $result = mysqli_query($GLOBALS['conn'], $query);

    if($result) {
        if (mysqli_num_rows($result) == 1) {
            $result_fetch = mysqli_fetch_assoc($result);

            $point = $result_fetch['referral_point'] + 10;

            $update_query = "UPDATE `registered_users` SET `referral_point` = '$point' WHERE `email` = '$result_fetch[email]'";

            if(!mysqli_query($GLOBALS['conn'], $update_query))
            {
                echo"
                    <script>
                        alert('Cannot Run Query');
                        window.location.href = 'index.php'; 
                    </script>
                ";
                exit;
            }
        }
        else {
            echo"
                <script>
                    alert('Invalid Referral Code');
                    window.location.href = 'index.php'; 
                </script>
            ";
            exit;
        }
    } else {
        echo"
            <script>
                alert('Cannot Run Query');
                window.location.href = 'index.php'; 
            </script>
        ";
        exit;
    }
}

if (isset($_POST['login']))
{
    $query = "SELECT * FROM `registered_users` WHERE `email` = '$_POST[email_username]' OR `user_name` = '$_POST[email_username]'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $result_fetch = mysqli_fetch_assoc($result);
            if (password_verify($_POST['password'], $result_fetch['password'])) {
                # if password metched
                $_SESSION['logged_in'] = true;
                $_SESSION['username'] = $result_fetch['user_name'];
                header("location: index.php");   
            }
            else {
                # if incorrect password
                echo"
                    <script>
                        alert('Incorrect password');
                        window.location.href = 'index.php'; 
                    </script>
                ";
            }
        } 
        else {
            echo"
                <script>
                    alert('Email or Username Not Registered');
                    window.location.href = 'index.php'; 
                </script>
            ";
        }
    }
    else {
        echo"
            <script>
                alert('Cannot Run Query');
                window.location.href = 'index.php'; 
            </script>
        ";
    }
}

# for registration
if (isset($_POST['register']))
{
    $user_exist_query = "SELECT * FROM `registered_users` WHERE `user_name` = '$_POST[username]' OR `email` = '$_POST[email]'";

    $result = mysqli_query($conn, $user_exist_query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            # if any user has already taken username or email
            $result_fetch = mysqli_fetch_assoc($result);
            if ($result_fetch['user_name'] == $_POST['username']){
                # error for username already registered
                echo"
                    <script>
                        alert('$result_fetch[user_name] - Is Already Taken');
                        window.location.href = 'index.php'; 
                    </script>
                ";
            }
            else {
                # error for email already registered
                echo"
                    <script>
                        alert('$result_fetch[email] - Is Already Registered');
                        window.location.href = 'index.php'; 
                    </script>
                ";
            }
        }
        else # this query will be executed when no one has taken username or email before
        {
            if($_POST['refcode'] != '')
            {
                updateReferral();
            }

            $referral_code = strtoupper(bin2hex(random_bytes(3)));            


            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

            $query = "INSERT INTO `registered_users`(`full_name`, `user_name`, `email`, `password`, `referral_code`, `referral_point`) VALUES ('$_POST[fullname]','$_POST[username]','$_POST[email]','$password', '$referral_code', 0)";

            if(mysqli_query($conn, $query)) {
                # if data inserted successfully
                echo"
                    <script>
                        alert('Registration Successful');
                        window.location.href = 'index.php'; 
                    </script>
                ";
            } 
            else {
                # if data cannot be inserted
                echo"
                    <script>
                        alert('Cannot Run Query');
                        window.location.href = 'index.php'; 
                    </script>
                ";
            }
        }
    }
    else {
        echo"
            <script>
                alert('Cannot Run Query');
                window.location.href = 'index.php'; 
            </script>
        ";
    }
}

?>