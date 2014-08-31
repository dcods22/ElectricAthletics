<?php

class TagNameController
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
        $entry =  $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($entry);
    }

}

$ID = $_GET['id'];

$tagNameController = new TagNameController('tag');
$tagNameController->getTagName($ID);