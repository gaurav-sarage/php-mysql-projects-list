<?php

    include 'core/init.php';
    $userObj->updateSession();
    
    if(isset($_GET['username']) && !empty($_GET['username']))
    {
        $profileData = $userObj->getUserByUsername($_GET['username']);
        $user = $userObj->userData();

        if(!$profileData) {
            $userObj->redirect('home.php');
        }else if ($profileData->username === $user->username) {
            $userObj->redirect('home.php');
        }
    }
    else {
        $userObj->redirect('home.php');
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <title>sleekSession - Live Video Chat</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <!-- Tailwind -->
        <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
        <!-- Font-awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- CSS -->
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL;?>assets/css/style.css">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700&display=swap" rel="stylesheet">
        <!-- Jquery -->
        <script
            src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
            crossorigin="anonymous"></script>
            <!-- Jquery timer -->
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/timer.jquery/0.7.0/timer.jquery.js">    
        </script>

        <script type="text/javascript">
            const conn = new WebSocket('ws://localhost:8080/?token=<?php echo $userObj->sessionID; ?> ');
        </script>

    </head>
    <body>
    <!-- AlertPopup -->
    <!-- CallPopup -->

    <!--WRAPPER-->
    <div class="wrapper h-screen items-center justify-center flex">

        <div class="inner flex bg-white w-4/5 border" style="height:70%; margin-bottom:10%;">
        <!--LEFT_SIDE-->
            <div class="w-2/5 border-r">
                <div class="h-full overflow-hidden">
                    <div class="flex justify-between items-center border-b">
                        <div class="mx-2 flex items-center justify-center">
                            <div class="flex-shrink-0 mx-2 my-4 rounded-full overflow-hidden h-12 w-12  cursor-pointer">
                                <img  class="w-full h-auto rounded-full select-none" src="<?php echo BASE_URL.$user->profileImage; ?>">
                            </div>
                            <div>
                                <span class="font-medium select-none">
                                    <?php
                                        echo $user->name;
                                    ?>
                                </span>
                            </div>
                        </div>
                        <div class="flex items-center mx-4">
                            <span class="select-none transition mx-3 text-green-400 cursor-pointer"><i class="fas fa-circle"></i></span>
                            <span class="select-none transition hover:text-gray-500 mx-3 text-gray-600 cursor-pointer"><i class="fas fa-comment-alt"></i></span>
                            <span class="menu-logout relative select-none transition hover:text-gray-500 mx-3 text-gray-600 cursor-pointer"><i class="fas fa-ellipsis-v"></i>
                            <div class="logout flex items-center justify-center rounded absolute right-0 top-2 bg-white border hover:bg-gray-200" style="width: 100px;height: 60px;">
                                <a href="logout.php" class="p-2 px-2 text-lg text-gray-600">
                                    Logout
                                </a>
                            </div>
                            </span>
                        </div>
                    </div>
                    <div class="px-6 py-5 select-none">
                        <input class="p-2 w-full rounded border" type="text" name="usersearch" placeholder="Search users">
                    </div>
                    <div class="select-none overflow-hidden overflow-y-auto h-2/4">
                        <h2 class="font-bold text-lg my-4  px-6 select-none">Users</h2>
                        <ul class="select-none">
                            <!-- USER-LIST -->
                            <?php
                                $userObj->getUsers();
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <!--LEFT_SIDE_END-->  
            <!--RIGHT_SIDE-->
            <div class="flex-2 flex rounded-xl w-full h-full ">
                <!-- PROFILE -->

                <div id="profile" class="flex flex-1 justify-center items-center">
                    <div class="flex flex-col flex-1 h-full overflow-hidden overflow-y-auto items-center justify-center">
                        <div class="w-60 h-60 right-img rounded-full overflow-hidden">
                            <img class="h-auto w-full" src="<?php echo BASE_URL.$profileData->profileImage;?>">
                        </div>
                        <div class="right-heading">
                            <h2 class="text-center">
                                <?php echo $profileData->name; ?>
                            </h2>
                            <p>Do you want to make a Call?</p>
                                <button 
                                    id="callBtn" data-user="<?php echo $profileData->userID; ?>" class="active:-top-2 relative transition border border-gray-400 shadow-md my-4 bg-green-400 hover:bg-green-500 p-4 px-5 rounded-full text-white text-xl"><i class="fas fa-video"></i>
                                </button>
                        </div>
                    </div>
                </div>
                    <!--PROFILE_SECTION_END-->  
                <!--PROFILE_SECTION_END-->  
                <!-- VIDEO -->
                <div id="video" class="hidden overflow-hidden flex items-center">
                    <div class="flex relative flex-col h-full">
                        <div class="order-2 h-full">
                            <video 
                                id="remoteVideo" class="h-full object-cover" style="width:1280px;" 
                                autoplay playinline>
                            </video>
                            <video 
                                id="localVideo" 
                                class="vid-2 z-1 right-0 bottom-1 absolute" 
                                autoplay playinline>
                            </video>
                        </div>
                        <div class="order-1 mt-4 absolute self-center">
                            <div 
                                class="time rounded-xl text-white font-bold py-1 px-4">
                                <span id="callTimer">
                                    
                                </span>
                            </div>
                        </div>
                        <div class="order-3 shadow-md flex justify-center btn-call-end items-end w-full h-full absolute ">
                            <button 
                                id="hangupBtn" 
                                class="relative -top-8 shadow-lg drop-shadow bg-red-600  rounded-full hover:bg-red-700 text-white text-2xl px-4 py-4 text-2xl">
                                <i 
                                    class="fas fa-video-slash">
                                </i> 
                            </button>
                        </div>
                    </div> 
                </div>
                <!--VIDEO_CALL_ENDS-->

            </div>
            <!--RIGHT_SIDE_END-->
        </div><!--INNER_ENDS-->
    </div><!--WRAPPER ENDS-->
    <!-- JavaScript Files -->
    <script 
        type="text/javascript" 
        src="<?php echo BASE_URL;?>
            assets/js/main.js">
    </script>
    <script 
        src="https://webrtc.github.io/adapter/adapter-latest.js">
    </script>
    </body>
</html>