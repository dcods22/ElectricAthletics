<html>
<head>
    <title>Electric Athletics - About</title>
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
                <div class="title">Validate</div>

                <?php

                    $ID = $_GET['id'];

                ?>
                <br>
                A validation email has been sent.
                <br/><br/>
                If you need to be resent please <a href="resendValidation.php?id=<?php echo $ID;?>">click here</a>
                <br/>
                <div class="HRGap"></div>
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