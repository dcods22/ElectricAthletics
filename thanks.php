<html>
<head>
    <title>Electric Athletics - About</title>
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
                <div class="title">Thanks!</div>

                <div class="thanks">
                    Thanks for reaching out to us.  We will reply no matter what, once we have received your message.
                    <br/>
                    <br/>
                    We really appreciate the correspondence and hopefully you continue to read our blog.
                </div>
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