<?php

    class ProfileController
    {
        private $dbconn;
        private $tablename;

        function __construct($tablename, $dbname = 'blogdatabase', $dblogin = 'dancody', $dbpass = 'tino24', $url = 'electricathleticscom.ipagemysql.com')
        {
            $this->dbconn = new PDO("mysql:host=$url;dbname=$dbname", "$dblogin", "$dbpass");
            $this->tablename = $tablename;
        }

        function getProfileInfo($id){
            $sql = 'SELECT email, username, avatar FROM Users WHERE ID=:id';

            $stmt = $this->dbconn->prepare( $sql );
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            $entry =  $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($entry);
        }

        function getCommentInfo(){
            $sql = 'SELECT ID, username, avatar FROM Users';

            $stmt = $this->dbconn->prepare( $sql );
            $stmt->execute();
            $entry =  $stmt->fetchall(PDO::FETCH_ASSOC);
            echo json_encode($entry);
        }

    }

    $ID = $_GET['id'];

    $profileController = new ProfileController('Users');

    if(isset($ID)){
        $profileController->getProfileInfo($ID);
    }else{
        $profileController->getCommentInfo();
    }
?>