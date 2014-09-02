<?php

class UpdateArticle
{
    private $dbconn;
    private $tablename;

    function __construct($tablename, $dbname = 'blogdatabase', $dblogin = 'dancody', $dbpass = 'tino24', $url = 'electricathleticscom.ipagemysql.com')
    {
        $this->dbconn = new PDO("mysql:host=$url;dbname=$dbname", "$dblogin", "$dbpass");
        $this->tablename = $tablename;
    }

    function updatePost($ID, $typeID, $title, $desc, $article, $pic, $picDesc, $picSrc){
       // build INSERT query string
       $sql = 'UPDATE `blogs` SET `typeID`=:typeID, `title`=:title, `desc`=:desc, `article`=:article, `pic`=:pic, `picDesc`=:picDesc, `picSrc`=:picSrc WHERE id=:id';

       $stmt = $this->dbconn->prepare( $sql );
       $stmt->bindValue(':id', $ID);
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

$articles = file_get_contents("php://input");
$article = json_decode($articles);
$ID = $article->id;
$typeID = $article->typeID;
$title = $article->title;
$desc = $article->desc;
$art = $article->article;
$pic = $article->pic;
$picDesc = $article->picDesc;
$picSrc = $article->picSrc;

$updateArticle = new UpdateArticle('blogs');
$updateArticle->updatePost($ID, $typeID, $title, $desc, $art, $pic, $picDesc, $picSrc);

?>