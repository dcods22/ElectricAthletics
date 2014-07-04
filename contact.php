<html>
<head>
    <title>Electric Athletics - Contact</title>
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
        $_SESSION['loggedin'] = "yes";
        $username = $_COOKIE['username'];
    }else
        $signedin = false;

    include("php/userInfo.php");

    $userController = new UserController("Users");
    $info = $userController->getUserInfo($username);
    $ID = $info[id];
    $email = $info[email];
    $avatar = $info[avatar];

?>

<nav>
    <div class="navHolder">
        <div class="searchUsername">
            <div class="search">
                <form method="POST" action="php/search.php" class="searchForm">
                    <input type="submit" value="Search" style="display: none; float:left;" />
                    <input type="text" placeholder="Search..." name="search" class="searchBar"/>
                </form>
            </div>
            <div class="LR">
                <?php
                if($_SESSION['loggedin'] == "yes"):
                    echo  "<div class='usernameholder'><a href='profile.php?id=" . $ID . "'><img src='" . $avatar . "' alt='Avatar' class='signinAvatar'/> <div class='nameuser'>" . $username . "</div></a></div>";
                else:
                    echo "<a href='signuporin.php' class='LRLink'>Login / Register</a>";
                endif;
                ?>
            </div>
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
                <div class="title">Contact</div>
                <pre>
    Feel free to contact us through this form or by emailing us at <a href="mailto:contact@electricathletics.com">contact@electricathletics.com</a>

    If you have any questions or concerns they will be responded too very shortly.
                </pre>

                <div class="contactDiv">
                    <form method="POST" action="php/sendEmail.php" class="formContact" name="formEmail">
                        <fieldset class="formGroup">
                            <p><input type="text" placeholder="Name" class="formName" name="formName" required/></p>
                            <p><input type="text" placeholder="Email" class="formEmail" name="formEmail" required/></p>
                            <p><textarea placeholder="Email Body" class="formBody" name="formBody" required></textarea></p>
                            <input type="submit" class="formSend" name="formSend" value="Send!"/>
                        </fieldset>
                    </form>
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