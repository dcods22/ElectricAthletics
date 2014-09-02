<?php

class AddTagsController
{
    private $dbconn;
    private $tablename;

    function __construct($tablename, $dbname = 'blogdatabase', $dblogin = 'dancody', $dbpass = 'tino24', $url = 'electricathleticscom.ipagemysql.com')
    {
        $this->dbconn = new PDO("mysql:host=$url;dbname=$dbname", "$dblogin", "$dbpass");
        $this->tablename = $tablename;
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

}

$tagsData = file_get_contents("php://input");
$tag = json_decode($tagsData);
$tags = $tag->tags;
$ID = $tag->ID;

$addTagsController =  new AddTagsController('tagList');

if(!is_null($tags)) {

    $newTagList = explode(",", $tags);
    foreach ($newTagList as $newTagPre):
        $newTag = trim($newTagPre);
        $addTagsController->addTagList($newTag);
        $newTagID = $addTagsController->getTagID($newTag);
        $addTagsController->addTags($newTagID, $ID);
    endforeach;
}
