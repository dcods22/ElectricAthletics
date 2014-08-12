<?php

class CommentController
{
    private $dbconn;
    private $tablename;

    function __construct($tablename, $dbname = 'blogdatabase', $dblogin = 'dancody', $dbpass = 'tino24', $url = 'electricathleticscom.ipagemysql.com')
    {
        $this->dbconn = new PDO("mysql:host=$url;dbname=$dbname", "$dblogin", "$dbpass");
        $this->tablename = $tablename;
    }

    function getUserInfo($userID){
        $sql = 'SELECT `username`, `email`, `avatar` FROM Users WHERE ID=:ID';

        $stmt = $this->dbconn->prepare( $sql );
        $stmt->bindValue(':ID', $userID);
        $stmt->execute();
        $entry =  $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($entry);
    }

    function addComment($userID, $articleID, $comment){
        // build INSERT query string
        $sql = 'INSERT INTO `comments` ( `articleID`, `userID`, `comment` ) VALUES ( :articleID, :userID, :comment )';
        $stmt = $this->dbconn->prepare( $sql );
        $stmt->bindValue(':articleID', $articleID);
        $stmt->bindValue(':userID', $userID);
        $stmt->bindValue(':comment', $comment);
        $stmt->execute();
    }

    function getArticleComments($articleID){
        $sql = 'SELECT * FROM comments WHERE articleID=:articleID';
        $stmt = $this->dbconn->prepare( $sql );
        $stmt->bindValue(':articleID', $articleID);
        $stmt->execute();
        $entry =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($entry);
    }

    function getUserComments($userID){
        $sql = 'SELECT * FROM comments WHERE userID=:userID';
        $stmt = $this->dbconn->prepare( $sql );
        $stmt->bindValue(':userID', $userID);
        $stmt->execute();
        $entry =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($entry);
    }

    function getArticleTitle($ID){
        $sql = 'SELECT `title` FROM blogs WHERE id=:ID';

        $stmt = $this->dbconn->prepare( $sql );
        $stmt->bindValue(':ID', $ID);
        $stmt->execute();
        $entry =  $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($entry);
    }
}

$ID = $_GET['id'];
$commentController = new CommentController('comments');
$commentController->getArticleComments($ID);

?>