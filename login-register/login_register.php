<?php 

require('connection.php');

# for login


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
            $query = "INSERT INTO `registered_users`(`full_name`, `user_name`, `email`, `password`) VALUES ('$_POST[fullname]','$_POST[username]','$_POST[email]','$_POST[password]')";

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