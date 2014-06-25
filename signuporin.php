<html>
<head>
    <title>Electric Athletics - Sign In/Register</title>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>

<body>

<nav>
    <div class="navHolder">
        <div class="LR">
            <a href="signuporin.php" class="LRLink">Login / Register</a>
        </div>
        <div class="navlinks">
            <a href="index.php">LOGO</a>
            <a href="index.php">Home</a>
            <a href="sports.php">Sports</a>
            <a href="technology.php">Technology</a>
            <a href="about.html">About</a>
            <a href="contact.php">Contact</a>
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


