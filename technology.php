<html>
    <head>
        <title>Electric Athletics - Technology</title>
        <link rel="stylesheet" type="text/css" href="css/style.css" />
    </head>

    <body>

    <?php
        include("php/blogFetch.php");

        $blogFetch = new BlogController("blogs");
        $blogs = $blogFetch->getTechPosts();
    ?>

    <nav>
        <div class="navLinks">
            <a href="index.php">LOGO</a>
            <a href="index.php">Home</a>
            <a href="sports.php">Sports</a>
            <a href="technology.php">Technology</a>
            <a href="about.html">About</a>
            <a href="contact.php">Contact</a>
        </div>
    </nav>

    <div class="container">
        <div class="holder">

            <div class="title">Technology</div>

            <?php
            foreach($blogs as $blog):
                $strDate = strtotime($blog[time]);
                $theDate = date( 'F j, Y g:i A', $strDate );
                ?>

                <div class="articlePreview">
                    <a href="article.php?id=<?php echo $blog[id]; ?>"><div class="articleTitle"><?php echo $blog[title]; ?></div></a><br/>
                    <a href="<?php if($blog[typeID] == 2){ echo "sports.php";} elseif($blog[typeID] == 1){ echo "technology.php"; }?>"><div class="type"><?php if($blog[typeID] == 1){ echo "Technology";} elseif($blog[typeID] == 2){ echo "Sports"; }?></div></a>
                    <div class="articleTime"><?php echo $theDate; ?></div>
                    <img src="<?php echo $blog[pic]; ?>" alt="Article Photo" class="articlePhoto" height="200px" width="300px"/>
                    <div class="articleDesc"><?php echo $blog[desc]; ?></div>
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


    </body>
</html>