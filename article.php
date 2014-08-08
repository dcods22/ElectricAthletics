<html>

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

        if($_SESSION['loggedin'] == "yes"):    

        include("php/userInfo.php");

            $userController = new UserController("Users");
            $info = $userController->getUserInfo($username);
            $ID = $info[id];
            $email = $info[email];
            $avatar = $info[avatar];

        endif;

        include("php/blogFetch.php");

        $articleID = $_GET['id'];
        $blogFetch = new BlogController("blogs");
        $blog = $blogFetch->getPostInfo($articleID);
        $tagList = $blogFetch->getArticleTags($articleID);
        $strDate = strtotime($blog[time]);
        $theDate = date( 'F j, Y g:i A', $strDate );

        include("php/commentController.php");
        $commentController = new CommentController("comments");
        $comments = $commentController->getArticleComments($articleID);
    ?>

    <head>
        <title><?php echo $blog[title];?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <meta name="Description" CONTENT="Sports and Technology blog">
        <meta name="keywords" context="Sports, Technology, <?php foreach($tagList as $tag):$tagName = $blogFetch->getTagName($tag[tagID]);echo $tagName . ', ';endforeach;?>" >
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
                    
                    <div class="blogTitle"><?php echo $blog[title]; ?></div>
                    <a href="<?php if($blog[typeID] == 2){ echo "sports.php";} elseif($blog[typeID] == 1){ echo "technology.php"; }?>"><div class="blogType"><?php if($blog[typeID] == 1){ echo "Technology";} elseif($blog[typeID] == 2){ echo "Sports"; }?></div></a>
                    <div class="blogTime"><?php echo $theDate; ?></div>
                    <div class="blogDesc"><?php echo $blog[desc]; ?></div>
                    <div class="tagHolder">
                        <span style="float:left;">Tags:</span> 
                        <?php
                            foreach($tagList as $tag):
                            $tagName = $blogFetch->getTagName($tag[tagID]);
                        ?>
                            <div class="tag"><a href="tags.php?id=<?php echo $tag[tagID] ?>"><?php echo $tagName; ?></a></div>
                        <?php
                            endforeach;
                        ?>
                    </div>  
                    <?php
                        if($ID == 11):
                    ?>
                       <br/> <div class="editLink"><a href="editArticle.php?id=<?php echo $articleID; ?>">Edit Article</a></div>
                    <?php
                        endif;        
                    ?>
                    <img src="<?php echo $blog[pic]; ?>" alt="Blog Photo" class="blogPhoto"/>
                    <div class="picDesc"><?php echo $blog[picDesc]; ?></div>
                    <div class="blogArticle">
                        <pre><?php echo $blog[article]; ?></pre>
                    </div>

                    <div class="commentFormDiv">
                        <form method="POST" action="php/postComment.php" class="commentForm">
                            <input type="hidden" name="userID" value="<?php echo $ID; ?>"/>
                            <input type="hidden" name="articleID" value="<?php echo $articleID; ?>"/>
                            <textarea class="commentText" name="commentText" placeholder="Comment Here..."></textarea>
                            <input type="submit" value="Post Comment"/>
                        </form>
                    </div>
                    <div class="comments">
                        <?php
                            if(count($comments) == 0):
                                echo "<span class='noComments'>There are no comments</span>";
                            else:
                            foreach($comments as $comment):
                        ?>

                           <div class="commentTitle">Comments:</div>
                           <div class="comment">
                               <?php
                                    $commenterInfo = $commentController->getUserInfo($comment[userID]);
                                    $strDate = strtotime($comment[time]);
                                    $commDate = date( 'F j, Y g:i A', $strDate );
                               ?>

                               <a href="electricathletics.com/profile.php?id=<?php echo $comment[userID]; ?>" class="commUser"><?php echo $commenterInfo[username]; ?>:</a>
                               <div class="commTime"><?php echo $commDate;?></div>
                               <div class="commText"><?php echo $comment[comment]; ?></div>
                           </div>


                        <?php
                            endforeach;
                            endif;
                        ?>
                    </div>

                    <div class="sources">
                        Picture source is from: <?php echo $blog[picSrc]; ?>
                    </div>
                </div>
            </div>


            <div class="hrGapArticle"></div>
            <hr/>

            <div class="footer">
                No pictures used on this website are original, they are all obtained from the source listed at the bottom of the page. <br/>
                All information found on this blog are original ideas written by our writers.  For any questions feel free to contact us by the contact page
                <br/>All rights reserved, &copy; 2014

            </div>

        </div>
    </div>


    </body>
</html>