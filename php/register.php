<?php

class Register
{
    private $dbconn;
    private $table;

    function __construct($tablename, $dbname = 'blogdatabase', $dblogin = 'dancody', $dbpass = 'tino24', $url = 'electricathleticscom.ipagemysql.com')
    {
        $this->dbconn = new PDO("mysql:host=$url;dbname=$dbname", "$dblogin", "$dbpass");
        $this->tablename = $tablename;
    }

    function make_salt_key()
    {
        $str = '/.0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $num = strlen($str) - 1;
        $salt = '$6$rounds=5000$';
        for($i = 0; $i < 21; $i++){
            $salt .= $str[mt_rand(0, $num)];
        }
        $salt .= '$';
        return($salt);
    }

    function addUser($email, $username, $password){
        // build INSERT query string
        $sql = 'INSERT INTO Users (email, username, password, avatar, validated)
					VALUES ( :username, :email , :password, :avatar, :validated )';
        $validated = 0;
        $avatar = "http://electricathletics.com/images/no_avatar.png";

        $stmt = $this->dbconn->prepare( $sql );
        $stmt->bindValue( ':usernameName', $username );
        $stmt->bindValue( ':email', $email );
        $stmt->bindValue( ':password', $password );
        $stmt->bindValue( ':avatar', $avatar );
        $stmt->bindValue( ':validated', $validated );
        $stmt->execute();
        echo $sql;
        
    }

    function getUserID($email)
    {
        //sql SELECT statement
        $sql = 'SELECT userId FROM Users WHERE email=:email;';

        // submit database query
        $stmt = $this->dbconn->prepare( $sql );
        $stmt->bindValue( ':email', $email );
        $stmt->execute();
        $entry = $stmt->fetch(PDO::FETCH_ASSOC);
        return($entry[userId]);
    }
}

    $subject = "Electric Athletics Validation";
    $headers = "From: noreply@electricathletics.com \r\n";

    $username = $_POST['registerUsername'];
    $email = $_POST['registerEmail'];
    $password = $_POST['registerPassword'];

    $email = trim($email);

    $register = new Register('Users');
    $password1 = crypt($password, $register->make_salt_key());
    $register->addUser($username, $email, $password1);
    $newID = $register->getUserID($email);
    $emailMessage = 'Click on the link to validate your Electric Athletics account.  <html><head></head><body><a href="http://electricathletics.com/validation.php?id=' . $newID .'">Click Here</a></body></html>';
    //mail($email, $subject, $emailMessage, $headers);
    header('Location: http://electricathletics.com/validate.php?id=' . $newID);

?>