<?php

class TagsController
{
    private $dbconn;
    private $tablename;

    function __construct($tablename, $dbname = 'blogdatabase', $dblogin = 'dancody', $dbpass = 'tino24', $url = 'electricathleticscom.ipagemysql.com')
    {
        $this->dbconn = new PDO("mysql:host=$url;dbname=$dbname", "$dblogin", "$dbpass");
        $this->tablename = $tablename;
    }

    function getTags($articleID){
        $tags = array();

        $sql = 'SELECT `tagID` FROM tags WHERE articleID=:articleID';
        $stmt = $this->dbconn->prepare( $sql );
        $stmt->bindValue(':articleID', $articleID);
        $stmt->execute();
        $tagIDs =  $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($tagIDs as $tagID){
            $sql1 = 'SELECT `tag` FROM tagList WHERE tagID=:tagID';
            $stmt1 = $this->dbconn->prepare( $sql1 );
            $stmt1->bindValue(':tagID', $tagID);
            $stmt1->execute();
            $tag =  $stmt1->fetch(PDO::FETCH_ASSOC);
            $tags = array_merge($tags, $tag);
        }

        echo json_encode($tags);
    }
}

$ID = $_GET['id'];

$tagController = new TagsController('tag');

if(isset($ID))
    $tagController->getTags($ID);