<?php

class BlogUpdate
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
        $sql = 'UPDATE `blogs` SET `typeID`=:typeID, `title`=:title, `desc`=:desc, `article`=:article, `pic`=:pic, `picDesc`=:picDesc, `picSrc`=:picDesc WHERE id=:id';

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

$blogUpdate = new BlogUpdate("blogs");
$ID = $_POST['id'];
$typeID = $_POST['addType'];
$title = $_POST['addTitle'];
$desc = $_POST['addDesc'];
$article = $_POST['addArticle'];
$pic = $_POST['addPic'];
$picDesc = $_POST['addPicDesc'];
$picSrc = $_POST['addPicSrc'];

$blogUpdate->updatePost($ID, $typeID, $title, $desc, $article, $pic, $picDesc, $picSrc);
header('Location: http://www.electricathletics.com/article.php?id=' . $ID);

?>