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
        <h2>Website Name</h2>
        <nav>
            <a href="index.php">HOME</a>
            <a href="index.php">BLOG</a>
            <a href="index.php">CONTACT</a>
            <a href="index.php">ABOUT</a>
        </nav>
        <div class="sign-in-up">
            <button type="button">LOGIN</button>
            <button type="button">REGISTER</button>
        </div>
    </header>

    <div class="popup-container">
        <div class="popup">
            <form>
                <h2>
                    <span>User Login</span>
                    <button type="reset">X</button>
                </h2>
                <input 
                    type="text" 
                    placeholder="Enter your E-mail or username"
                >
                <input 
                    type="password" 
                    placeholder="Enter your password"
                >
                <button type="submit" class="login-btn">Login</button>
            </form>
        </div>
    </div>


    <div class="popup-container">
        <div class="register popup">
            <form>
                <h2>
                    <span>User Register</span>
                    <button type="reset">X</button>
                </h2>
                <input 
                    type="text" 
                    placeholder="Enter your Full Name"
                >
                <input 
                    type="text"
                    placeholder="Enter your Username"
                
                >
                <input 
                    type="email" 
                    placeholder="Enter your E-mail"
                >
                <input 
                    type="password"
                    placeholder="Enter your Password"
                >
                <button type="submit" class="register-btn">Register</button>
            </form>
        </div>
    </div>
</body>
</html>