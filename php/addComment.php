<?php

    class AddComment
    {
        private $dbconn;
        private $tablename;

        function __construct($tablename, $dbname = 'blogdatabase', $dblogin = 'dancody', $dbpass = 'tino24', $url = 'electricathleticscom.ipagemysql.com')
        {
            $this->dbconn = new PDO("mysql:host=$url;dbname=$dbname", "$dblogin", "$dbpass");
            $this->tablename = $tablename;
        }

        function addComment($userID, $articleID, $comment){
            // build INSERT query string
            $sql = 'INSERT INTO `comments` ( `articleID`, `userID`, `comment` ) VALUES ( :articleID, :userID, :comment )';
            $stmt = $this->dbconn->prepare( $sql );
            $stmt->bindValue(':articleID', $articleID);
            $stmt->bindValue(':userID', $userID);
            $stmt->bindValue(':comment', $comment);
            $stmt->execute();
            //echo json_encode("Success");
        }
    }

    $commentData = file_get_contents("php://input");
    $comments = json_decode($commentData);
    $userID = $comments->userID;
    $articleID = $comments->articleID;
    $comment = $comments->comment;

    $addComment = new AddComment('Users');
    $addComment->addComment($userID, $articleID, $comment);

?>