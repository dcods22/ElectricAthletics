<html>
<head>
    <title>Electric Athletics - Sign In/Register</title>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>

<body>

<?php
    session_save_path("/home/users/web/b2834/ipg.electricathleticscom/sessions");
    session_start();

    if(isset($_SESSION['loggedin'])){
        if($_SESSION['loggedin'] = "yes")
            $signedin = true;
    }

    if(isset($_SESSION['username'])){
        $username = $_SESSION['username'];
    }

    if(isset($_COOKIE['remember_me'])){
        session_id($_COOKIE['remember_me']);
        $signedin = true;
    }

    include("php/userInfo.php");

    $userController = new UserController("Users");
    $info = $userController->getUserInfo($username);
    $ID = $info[id];
    $email = $info[email];
    $avatar = $info[avatar];

?>

<nav>
    <div class="navHolder">
        <div class="LR">
            <?php
            if($_SESSION['loggedin'] == "yes"):
                echo  "<div class='usernameholder'><a href='profile.php?id=" . $ID . "'><img src='" . $avatar . "' alt='Avatar' class='signinAvatar'/> <div class='nameuser'>" . $username . "</div></a></div>";
            else:
                echo "<a href='signuporin.php' class='LRLink'>Login / Register</a>";
            endif;
            ?>
        </div>
        <div class="navlinks">
            <div class="logo"><a href="index.php">LOGO</a></div>
            <div class="rNav">
                <a href="index.php">Home</a>
                <a href="sports.php">Sports</a>
                <a href="technology.php">Technology</a>
                <a href="about.php">About</a>
                <a href="contact.php">Contact</a>
            </div>
        </div>
    </div>
</nav>


<div class="container">
    <div class="holder">
        <div class="articleHolder">
            <div class="articleContainer">
                <div class="title">Login</div>

                <?php

                    $error = $_GET['error'];

                    if($error == 1)
                        echo "<div class='error'> Wrong Credentials </div>";
                    else if($error ==2)
                        echo "<div class='error'> Email is not validated click here to resend it <a href=''>Resend Validation Email></a> </div>";

                ?>

                <form method="POST" action="php/login.php" class="loginForm">
                    <formset>
                        <input type="text" name="loginUsername" class="loginUsername" id="loginUsername" placeholder="Username/Email"/>
                        <input type="password" name="loginPassword" class="loginPassword" id="loginPassword" placeholder="Password"/>
                        <input type="submit" value="Sign In!"name="loginSend" class="loginSend" id="loginSend"/>
                    </formset>
                </form>


                <div class="title">Register</div>
                <form method="POST" action="php/register.php" class="registerForm">
                    <formset>
                        <input type="text" name="registerUsername" class="registerUsername" id="registerUsername" placeholder="Username"/>
                        <input type="text" name="registerEmail" class="registerEmail" id="registerEmail" placeholder="Email"/>
                        <input type="password" name="registerPassword" class="registerPassword" id="registerPassword" placeholder="Password"/>
                        <input type="password" name="registerPassword2" class="registerPassword2" id="registerPassword2" placeholder="Re-type Password"/>
                        <input type="submit" value="Register!" name="regiterSend" class="registerSend" id="registerSend"/>
                    </formset>
                </form>


            </div>
        </div>


        <div class="contactHRGap"></div>
        <hr/>

        <div class="footer">
            No pictures used on this website are original, they are all obtained from the source listed at the bottom of the
            page. <br/>
            All information found on this blog are original ideas written by our writers. For any questions feel free to contact
            us by the contact page
            <br/>All rights reserved, &copy; 2014

        </div>

    </div>
</div>


</body>
</html>


