<?php

class UpdateProfile
{
    private $dbconn;
    private $tablename;

    function __construct($tablename, $dbname = 'blogdatabase', $dblogin = 'dancody', $dbpass = 'tino24', $url = 'electricathleticscom.ipagemysql.com')
    {
        $this->dbconn = new PDO("mysql:host=$url;dbname=$dbname", "$dblogin", "$dbpass");
        $this->tablename = $tablename;
    }

    function updateProfile($ID, $username, $avatar, $email){
        $sql = 'UPDATE `Users` SET `username`=:username, `avatar`=:avatar, `email`=:email WHERE ID=:id';

       $stmt = $this->dbconn->prepare( $sql );
       $stmt->bindValue(':username', $username);
       $stmt->bindValue(':avatar', $avatar);
       $stmt->bindValue(':email', $email);
       $stmt->bindValue(':id', $ID);
       $stmt->execute();
    }

}

$profiles = file_get_contents("php://input");
$profile = json_decode($profiles);
$ID = $profile->ID;
$username = $profile->username;
$avatar = $profile->avatar;
$email = $profile->email;

$updateProfile = new UpdateProfile('Users');
$updateProfile->updateProfile($ID, $username, $avatar, $email);

?>