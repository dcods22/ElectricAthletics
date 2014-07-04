<?php

    class UserController
    {
        private $dbconn;
        private $tablename;

        function __construct($tablename, $dbname = 'blogdatabase', $dblogin = 'dancody', $dbpass = 'tino24', $url = 'electricathleticscom.ipagemysql.com')
        {
            $this->dbconn = new PDO("mysql:host=$url;dbname=$dbname", "$dblogin", "$dbpass");
            $this->tablename = $tablename;
        }

        function getUserInfo($username){
            $sql = 'SELECT `id`, `email`, `avatar` FROM Users WHERE username=:username';

            $stmt = $this->dbconn->prepare( $sql );
            $stmt->bindValue(':username', $username);
            $stmt->execute();
            $entry =  $stmt->fetch(PDO::FETCH_ASSOC);
            return ($entry);
        }
    }
?>