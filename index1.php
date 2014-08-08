<html>

    <?php
        include("php/blogFetch.php");

        session_save_path("/home/users/web/b2834/ipg.electricathleticscom/sessions");
        session_start();

        $blogFetch = new BlogController("blogs");
        $blogs = $blogFetch->getAllPosts();

        if(isset($_SESSION['loggedin'])){
            if($_SESSION['loggedin'] = "yes")
                $signedin = true;
            else
                $signedin = false;
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

    <head>
        <title>Electric Athletics - Home</title>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <meta name="Description" CONTENT="Sports and Technology blog">
        <meta name="keywords" context="Sports, Technology" >
        <link rel="stylesheet" type="text/css" href="css/style.css" />
    </head>

    <body>
    <nav>
        <div class="navHolder">
            <div class="searchUsername">
                <div class="search">
                    <form method="POST" action="search.php" class="searchForm">
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
                    <a href="about.html">About</a>
                    <a href="contact.php">Contact</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="holder">

            <div class="title">Sports & Technology</div>

            <?php
                foreach($blogs as $blog):
                $strDate = strtotime($blog[time]);
                $theDate = date( 'F j, Y g:i A', $strDate );
                $desc1 = substr($blog[article], 0, 500);
                $words = explode(' ', $desc1);
                $last_word = array_pop($words);
                $desc2 = implode(' ', $words);
                $desc = trim($desc1) . "...";
            ?>

                <div class="articlePreview">
                    <a href="article.php?id=<?php echo $blog[id]; ?>"><div class="articleTitle"><?php echo $blog[title]; ?></div></a><br/>
                    <a href="<?php if($blog[typeID] == 2){ echo "sports.php";} elseif($blog[typeID] == 1){ echo "technology.php"; }?>"><div class="type"><?php if($blog[typeID] == 1){ echo "Technology";} elseif($blog[typeID] == 2){ echo "Sports"; }?></div></a>
                    <div class="articleTime"><?php echo $theDate; ?></div>
                    <img src="<?php echo $blog[pic]; ?>" alt="Article Photo" class="articlePhoto" height="200px" width="300px"/>
                    <div class="articleDesc"><?php echo $desc; ?></div>
                    <a href="article.php?id=<?php echo $blog[id]; ?>" class="readMore">Read More...</a>
                </div>

            <?php
            endforeach;
            ?>

            <div class="hrGap"></div>
            <hr/>

            <div class="footer">
                No pictures used on this website are original, they are all obtained from the source listed at the bottom of the page. <br/>
                All information found on this blog are original ideas written by our writers.  For any questions feel free to contact us by the contact page
                <br/>All rights reserved, &copy; 2014

            </div>

        </div>
    </div>


    <scipt src="js/angular.min.js"></script>

    </body>
</html>