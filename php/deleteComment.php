<?php

    class DeleteCommentController
    {
        private $dbconn;
        private $tablename;

        function __construct($tablename, $dbname = 'blogdatabase', $dblogin = 'dancody', $dbpass = 'tino24', $url = 'electricathleticscom.ipagemysql.com')
        {
            $this->dbconn = new PDO("mysql:host=$url;dbname=$dbname", "$dblogin", "$dbpass");
            $this->tablename = $tablename;
        }

        function deleteComment($ID){
            $sql = 'DELETE FROM `comments` WHERE commentID=:commentID';
            $statement = $this->dbconn->prepare( $sql );
            $statement->bindValue(':commentID', $ID);
            $statement->execute();
        }
    }

    $ID = $_GET['id'];
    $deleteCommentController = new DeleteCommentController('blogs');
    $deleteCommentController->deleteComment($ID);

?>