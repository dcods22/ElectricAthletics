<?php

    class emailController
    {
        private $dbconn;
        private $tablename;

        function __construct($tablename, $dbname = 'blogdatabase', $dblogin = 'dancody', $dbpass = 'tino24', $url = 'electricathleticscom.ipagemysql.com')
        {
            $this->dbconn = new PDO("mysql:host=$url;dbname=$dbname", "$dblogin", "$dbpass");
            $this->tablename = $tablename;
        }

        function checkUsername(){
            $sql = 'SELECT `username` FROM Users';
            $stmt = $this->dbconn->prepare( $sql );
            $stmt->execute();
            $entry =  $stmt->fetchall(PDO::FETCH_ASSOC);
            echo json_encode($entry);
        }
    }

    $emailController = new emailController('Users');
    $emailController->checkUsername();

?>