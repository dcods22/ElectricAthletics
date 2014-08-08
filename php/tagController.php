<?php

class tagController
{
    private $dbconn;
    private $tablename;

    function __construct($tablename, $dbname = 'blogdatabase', $dblogin = 'dancody', $dbpass = 'tino24', $url = 'electricathleticscom.ipagemysql.com')
    {
        $this->dbconn = new PDO("mysql:host=$url;dbname=$dbname", "$dblogin", "$dbpass");
        $this->tablename = $tablename;
    }

    function getTagName($tagID){
        $sql = 'SELECT `tag` FROM tagList WHERE tagID=:tagID';
        $stmt = $this->dbconn->prepare( $sql );
        $stmt->bindValue(':tagID', $tagID);
        $stmt->execute();
        $entry =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($entry);
    }

    function getAllTags(){
        $sql = 'SELECT `tagID`, `articleID` FROM tags';
        $stmt = $this->dbconn->prepare( $sql );
        $stmt->execute();
        $entry =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($entry);
    }

    function getArticleTag($articleID){
        $sql = 'SELECT `tagID` FROM tags WHERE articleID=:articleID';
        $stmt = $this->dbconn->prepare( $sql );
        $stmt->bindValue(':articleID', $articleID);
        $stmt->execute();
        $entry =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($entry);
    }

    function getTagList(){
        $sql = 'SELECT * FROM tagList';
        $stmt = $this->dbconn->prepare( $sql );
        $stmt->execute();
        $entry =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($entry);
    }
}

$ID = $_GET['id'];

$TagController = new TagController('tag');

?>