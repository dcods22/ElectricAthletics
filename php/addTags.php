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

        function addTags($tagID, $articleID){
            // build INSERT query string
            $sql = 'INSERT INTO `tags` ( `tagID`, `articleID`) VALUES ( :tagID, :articleID )';
            $stmt = $this->dbconn->prepare( $sql );
            $stmt->bindValue(':tagID', $tagID);
            $stmt->bindValue(':articleID', $articleID);
            $stmt->execute();
        }
    }

    $tagListData = file_get_contents("php://input");
    $tagList = json_decode($tagListData);
    $tags = $tagList->tags;
    $ID = $tagList->ID;

    $addTagsController = new AddTagsController('tagList');

    foreach($tags as $t){
        $addTagsController->addTags($t->tagID, $ID);
    }

?>
