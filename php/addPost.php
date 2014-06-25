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

    }

    $blogAdd = new BlogAdd("blogs");

    $typeID = $_POST['addType'];
    $title = $_POST['addTitle'];
    $desc = $_POST['addDesc'];
    $article = $_POST['addArticle'];
    $pic = $_POST['addPic'];
    $picDesc = $_POST['addPicDesc'];
    $picSrc = $_POST['addPicSrc'];

    $blogAdd->addPost($typeID, $title, $desc, $article, $pic, $picDesc, $picSrc);
    header('Location: http://www.electricathletics.com/');

?>