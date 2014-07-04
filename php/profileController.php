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
        $sql = 'SELECT * FROM Users WHERE ID=:id';

        $stmt = $this->dbconn->prepare( $sql );
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $entry =  $stmt->fetch(PDO::FETCH_ASSOC);
        return ($entry);
    }
}
?>