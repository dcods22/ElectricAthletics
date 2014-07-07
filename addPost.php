<html>
<head>
    <title>Electric Athletics - Add Post</title>
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

    include("php/tagController.php");
    $tagController = new TagController("tagList");
    $tags = $tagController->getTagList();
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
                <div class="title">Add Post</div>

                <div class="addPostDiv">
                    <form method="POST" action="php/addPost.php" class="addPostForm">
                        <formset>
                            <input type="radio" name="addType" id="addType" class="addType" value="2"/> Sports
                            <input type="radio" name="addType" id="addType" class="addType" value="1"/>Technology<br/>
                            <input type="text" name="addTitle" placeholder="Title"><br/>
                            <textarea type="text" name="addDesc" id="addDesc" class="addDesc" placeholder="Description"></textarea><br/>
                            <input type="text" name="addPic" id="addPic" class="addPic" placeholder="Picture Link"><br/>
                            <input type="text" name="addPicDesc" id="addPicDesc" class="addPicDesc" placeholder="Picture Description"/><br/>
                            <input type="text" name="addPicSrc" id="addPicSrc" class="addPicSrc" placeholder="Picture Source"/><br/>
                            <textarea placeholder="Article" name="addArticle" id="addArticle" class="addArticle"></textarea>
                            <select multiple="multiple" size="5" name="tags[]" class="tagList">
                                <?php
                                    foreach($tags as $tag):
                                ?>
                                    <option value="<?php echo $tag[tagID]; ?>" class="tags" name="tags[]"><?php echo $tag[tag]; ?></option>
                                <?php
                                    endforeach;
                                ?>
                            </select>
                            <input type="text" name="tagOther" id="tagOther" class="tagOther" placeholder="Other Tags seperated by ,"/><br/>
                            <input type="submit" name="sendArticle" class="sendArticle" id="sendArticle" >
                        </formset>
                    </form>
                   </div>
                <br/>
            </div>
        </div>


        <div class="hrGapArticle"></div>
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



