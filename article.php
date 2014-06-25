<html>
    <?php
        include("php/blogFetch.php");

        $articleID = $_GET['id'];
        $blogFetch = new BlogController("blogs");
        $blog = $blogFetch->getPostInfo($articleID);
        $strDate = strtotime($blog[time]);
        $theDate = date( 'F j, Y g:i A', $strDate );
    ?>
    <head>
        <title><?php echo $blog[title];?></title>
        <link rel="stylesheet" type="text/css" href="css/style.css" />
    </head>

    <body>

    <nav>
        <div class="navHolder">
            <div class="LR">
                <a href="signuporin.html" class="LRLink">Login / Register</a>
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
                    <div class="blogTitle"><?php echo $blog[title]; ?></div>
                    <a href="<?php if($blog[typeID] == 2){ echo "sports.php";} elseif($blog[typeID] == 1){ echo "technology.php"; }?>"><div class="blogType"><?php if($blog[typeID] == 1){ echo "Technology";} elseif($blog[typeID] == 2){ echo "Sports"; }?></div></a>
                    <div class="blogTime"><?php echo $theDate; ?></div>
                    <div class="blogDesc"><?php echo $blog[desc]; ?></div>
                    <img src="<?php echo $blog[pic]; ?>" alt="Blog Photo" class="blogPhoto"/>
                    <div class="picDesc"><?php echo $blog[picDesc]; ?></div>
                    <div class="blogArticle">
                        <pre><?php echo $blog[article]; ?></pre>
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