<?php 

class Login
{
    private $dbconn;
    private $table;

    function __construct($tablename, $dbname = 'blogdatabase', $dblogin = 'dancody', $dbpass = 'tino24', $url = 'electricathleticscom.ipagemysql.com')
    {
        $this->dbconn = new PDO("mysql:host=$url;dbname=$dbname", "$dblogin", "$dbpass");
        $this->tablename = $tablename;
    }

    // checks login passwords should be sent unhashed.
    function validate_login($username, $password)
    {
        // SQL Query gets the user's password via there email
        $sql = 'SELECT password FROM Users WHERE email=:username OR username=:username1';
        $result = $this->dbconn->prepare($sql);
        $result->bindValue(':username', $username);
        $result->bindValue(':username1', $username);
        $result->execute();
        $entry = $result->fetch();

        // if no entry is found login fails
        if ($entry == false) {
            return false;
        }

        // checks the password against the password hash
        return (crypt($password, $entry[password]) == $entry[password]);
    }

    function getUserName($username){
        // SQL Query gets the user's password via there email
        $sql = 'SELECT `id`, `username` FROM Users WHERE email=:username OR username=:username1';
        $result = $this->dbconn->prepare($sql);
        $result->bindValue(':username', $username);
        $result->bindValue(':username1', $username);
        $result->execute();
        $entry = $result->fetch();
        return $entry[username];
    }

    function checkActive($email)
    {
        $sql = 'SELECT validated FROM Users WHERE email=:email OR username=:email1';
        $result = $this->dbconn->prepare($sql);
        $result->bindValue(':email', $email);
        $result->bindValue(':email1', $email);
        $result->execute();
        $entry = $result->fetch();
        return ($entry[validated] == 1);
    }
}
    $username = $_GET['user'];
    $password = $_GET['pass'];
    $login = new Login('Users');

    if($login->validate_login($username, $password)){
        if($login->checkActive($username)){
            // starts the user's session
            $info = $login->getUserName($username);
            echo json_encode("Test3");

        }
        else
            echo json_encode("test");
    }else
        echo json_encode("test2");

?>