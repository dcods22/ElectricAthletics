<?php

    class AddArticleController
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

        function getArticleID($title){
            $sql = 'SELECT `id` FROM blogs WHERE title=:title';

            $stmt = $this->dbconn->prepare( $sql );
            $stmt->bindValue(':title', $title);
            $stmt->execute();
            $entry =  $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($entry[id]);
        }
    }

    $articles = file_get_contents("php://input");
    $article = json_decode($articles);
    $typeID = $article->type;
    $title = $article->title;
    $desc = $article->desc;
    $art = $article->article;
    $pic = $article->pic;
    $picDesc = $article->picDesc;
    $picSrc = $article->picSrc;

    $addArticleController = new AddArticleController('blogs');
    $addArticleController->addPost($typeID, $title, $desc, $art, $pic, $picDesc, $picSrc);
    $addArticleController->getArticleID($title);

?>