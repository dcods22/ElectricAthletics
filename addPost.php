<html>
<head>
    <title>Electric Athletics - Add Post</title>
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



