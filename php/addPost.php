<?php

    class BlogAdd
    {
        private $dbconn;
        private $tablename;

        function __construct($tablename, $dbname = 'blogdatabase', $dblogin = 'dancody', $dbpass = 'tino24', $url = 'electricathleticscom.ipagemysql.com')
        {
            $this->dbconn = new PDO("mysql:host=$url;dbname=$dbname", "$dblogin", "$dbpass");
            $this->tablename = $tablename;
        }

        function addPost($typeID, $title, $desc, $article, $pic, $picDesc, $picSrc){
            // build INSERT query string
            $sql = 'INSERT INTO `blogs` (`typeID`, `title`, `desc`, `article`, `pic`, `picDesc`, `picSrc`) VALUES ( :typeID, :title, :desc, :article, :pic, :picDesc, :picSrc )';

            $stmt = $this->dbconn->prepare( $sql );
            $stmt->bindValue(':typeID', $typeID);
            $stmt->bindValue(':title', $title);
            $stmt->bindValue(':desc', $desc);
            $stmt->bindValue(':article', $article);
            $stmt->bindValue(':pic', $pic);
            $stmt->bindValue(':picDesc', $picDesc);
            $stmt->bindValue(':picSrc', $picSrc);

            $stmt->execute();
        }

        function addTagList($tag){
            // build INSERT query string
            $sql = 'INSERT INTO `tagList` ( `tag` ) VALUES ( :tag )';
            $stmt = $this->dbconn->prepare( $sql );
            $stmt->bindValue(':tag', $tag);
            $stmt->execute();
        }


        function addTags($tagID, $articleID){
            // build INSERT query string
            $sql = 'INSERT INTO `tags` ( `tagID`, `articleID`) VALUES ( :tagID, :articleID )';
            $stmt = $this->dbconn->prepare( $sql );
            $stmt->bindValue(':tagID', $tagID);
            $stmt->bindValue(':articleID', $articleID);
            $stmt->execute();

        }

        function getTagID($tag){
            $sql = 'SELECT `tagID` FROM tagList WHERE tag=:tag';

            $stmt = $this->dbconn->prepare( $sql );
            $stmt->bindValue(':tag', $tag);
            $stmt->execute();
            $entry =  $stmt->fetch(PDO::FETCH_ASSOC);
            return ($entry[tagID]);
        }

        function getArticleID($title){
            $sql = 'SELECT `id` FROM blogs WHERE title=:title';

            $stmt = $this->dbconn->prepare( $sql );
            $stmt->bindValue(':title', $title);
            $stmt->execute();
            $entry =  $stmt->fetch(PDO::FETCH_ASSOC);
            return ($entry[id]);
        }
    }

    $blogAdd = new BlogAdd("blogs");

    $typeID = $_POST['addType'];
    $title = $_POST['addTitle'];
    $desc = $_POST['addDesc'];
    $article = $_POST['addArticle'];
    $pic = $_POST['addPic'];
    $picDesc = $_POST['addPicDesc'];
    $picSrc = $_POST['addPicSrc'];

    $addPost = $blogAdd->addPost($typeID, $title, $desc, $article, $pic, $picDesc, $picSrc);
    $articleID = $blogAdd->getArticleID($title);

    if(!empty($_POST['tags'])) {
        foreach ($_POST['tags'] as $tag):
            $blogAdd->addTags($tag, $articleID);
        endforeach;
    }

    //parse string and add to tag list then add tag
    if(!empty($_POST['tagOther'])) {
        $newTags = $_POST['tagOther'];
        $newTagList = explode(",", $newTags);

        foreach ($newTagList as $newTagPre):
            $newTag = trim($newTagPre);
            $blogAdd->addTagList($newTag);
            $newTagID = $blogAdd->getTagID($newTag);
            $blogAdd->addTags($newTagID, $articleID);
        endforeach;
    }

    header('Location: http://www.electricathletics.com/');

?>