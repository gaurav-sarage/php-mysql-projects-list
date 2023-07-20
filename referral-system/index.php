<?php 
    require('connection.php');
    session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Register Form</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h2>
            Website Name
        </h2>
        <nav>
            <a href="index.php">HOME</a>
            <a href="index.php">BLOG</a>
            <a href="index.php">CONTACT</a>
            <a href="index.php">ABOUT</a>
        </nav>
        <?php
            if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true)
            {
                echo"
                    <div class='user'>
                        $_SESSION[username] - <a href='logout.php'>
                            LOGOUT
                        </a>
                    </div>                
                ";
            }
            else {
                echo"
                    <div class='sign-in-up'>
                        <button type='button' onclick=\"popup('login-popup')\">
                            LOGIN
                        </button>
                        <button type='button' onclick=\"popup('register-popup')\">
                            REGISTER
                        </button>
                    </div>
                ";
            }
            

        ?>

    </header>

    <div class="popup-container" id="login-popup">
        <div class="popup">
            <form  
                method="POST"
                action="login_register.php"
            >
                <h2>
                    <span>User Login</span>
                    <button 
                        type="reset" 
                        onclick="popup('login-popup')"
                    >
                        X
                    </button>
                </h2>

                <input 
                    type="text" 
                    placeholder="Enter your E-mail or username"
                    name="email_username"
                >
                <input 
                    type="password" 
                    placeholder="Enter your password"
                    name="password"
                >
                <button 
                    type="submit"
                    class="login-btn"
                    name="login"
                >
                    Login
                </button>
            </form>
        </div>
    </div>


    <div class="popup-container" id="register-popup">
        <div class="register popup">
            <form method="POST" action="login_register.php">
                <h2>
                    <span>User Register</span>
                    <button 
                        type="reset"
                        onclick="popup('register-popup')"
                    >
                        X
                    </button>
                </h2>
                <input 
                    type="text" 
                    placeholder="Enter your Full Name"
                    name="fullname"
                >
                <input 
                    type="text"
                    placeholder="Enter your Username"
                    name="username"
                >
                <input 
                    type="email" 
                    placeholder="Enter your E-mail"
                    name="email"
                >
                <input 
                    type="password"
                    placeholder="Enter your Password"
                    name="password"
                >
                <input 
                    type="text"
                    placeholder="Enter your referral code"
                    name="refcode"
                    id="refercode"
                    >
                <button 
                    type="submit" 
                    class="register-btn"
                    name="register"
                >
                    Register
                </button>
            </form>
        </div>
    </div>

    <?php
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true)
        {
            echo"
                <h1 style='text-align: center; margin-top: 200px;'                >
                    Welcome to the website - $_SESSION[username]                 
                </h1>            
            ";

            $query = "SELECT * FROM `registered_users` WHERE `user_name` = '$_SESSION[username]'";

            $result = mysqli_query($conn, $query);
            $result_fetch = mysqli_fetch_assoc($result);

            echo "<h3 class='box'> Your Referral Code: $result_fetch[referral_code]</h3>";

            echo "<h3 class='box'> Your Referral Points: $result_fetch[referral_point]</h3>";

            echo "
                <h3 class='box'> Your Referral Link: 
                    <a 
                        href='http://localhost/referral-system/?refer=$result_fetch[referral_code]'
                    >
                        http://localhost/referral-system/?refer=$result_fetch[referral_code]
                    </a>                
                </h3>";
        }

    ?>


    <script>
        function popup(popup_name) {
            get_popup = document.getElementById(popup_name);
            if (get_popup.style.display == "flex") {
                get_popup.style.display = "none";
            } else {
                get_popup.style.display = "flex";
            }
        }
    </script>

    <?php
        if(isset($_GET['refer']) && $_GET['refer'] != '')
        {
            if (!(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true))
            {
                $query = "SELECT * FROM `registered_users` WHERE `referral_code` = '$_GET[refer]'";

                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) == 1){
                    echo"
                        <script>
                            document.getElementById('refercode').value='$_GET[refer]';
                            popup('register-popup');
                        </script>
                    ";
                }
                else {
                    echo"
                        <script>
                            alert('Invalid Referral Code');
                        </script>
                    ";
                }
            }
        }
    ?>

</body>
</html>