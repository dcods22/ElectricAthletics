<?php

class TagArticlesController
{
    private $dbconn;
    private $tablename;

    function __construct($tablename, $dbname = 'blogdatabase', $dblogin = 'dancody', $dbpass = 'tino24', $url = 'electricathleticscom.ipagemysql.com')
    {
        $this->dbconn = new PDO("mysql:host=$url;dbname=$dbname", "$dblogin", "$dbpass");
        $this->tablename = $tablename;
    }

    function getArticles($tagID){
        $articles = array();

        $sql = "SELECT `articleID` FROM `tags` WHERE tagID=:tagID";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->bindValue(':tagID', $tagID);
        $stmt->execute();
        $artIDs = $stmt->fetchall(PDO::FETCH_ASSOC);

        foreach($artIDs as $artID){
            $sql1 = "SELECT `id`, `typeID`,`pic`, `title`, `article`, `time` FROM `blogs` WHERE id=:articleID";
            $stmt1 = $this->dbconn->prepare($sql1);
            $stmt1->bindValue(':articleID', $artID[articleID]);
            $stmt1->execute();
            $art = $stmt1->fetchall(PDO::FETCH_ASSOC);
            $articles = array_merge($articles, $art);
        }

        echo json_encode($articles);
    }

}

$ID = $_GET['id'];

$tagArticlesController = new TagArticlesController('tag');
$tagArticlesController->getArticles($ID);
