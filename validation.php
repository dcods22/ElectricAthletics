<?php

class ValidationHandler
{
    private $dbconn;
    private $table;

    function __construct($tablename, $dbname = 'blogdatabase', $dblogin = 'dancody', $dbpass = 'tino24', $url = 'electricathleticscom.ipagemysql.com')
    {
        $this->dbconn = new PDO("mysql:host=$url;dbname=$dbname", "$dblogin", "$dbpass");
        $this->tablename = $tablename;
    }

    function updateValidation($ID){
        $sql = 'UPDATE `Users` SET validated=1 WHERE ID=:ID';
        $stmt = $this->dbconn->prepare( $sql );
        $stmt->bindValue(':ID', $ID);
        $stmt->execute();
    }

}

    $ID = $_GET['id'];
    $ValidationHandler = new ValidationHandler('Users');
    $ValidationHandler->updateValidation($ID);

    // starts the user's session
    session_save_path("/home/users/web/b2942/ipg.electricathletics/sessions");
    session_start();
    $_SESSION['loggedin'] = "yes";
    $_SESSION['username'] = $username;

    // if the user checked the remember me, this adds a cookie to save the user's session id
    if(isset($_POST['remember'])){
        $timeLength = 86400 * 365;
        setcookie('remember_me', session_id(), time()+$timeLength, '/', 'electricathletics.com');
    }
    header('Location: http://electricathletics.com/');

?>