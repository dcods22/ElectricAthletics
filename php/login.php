<?php //Code by Dan Cody

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
        $sql = 'SELECT email,password FROM Users WHERE email=:username OR username=:username';
        $result = $this->dbconn->prepare($sql);
        $result->bindValue(':username', $username);
        $result->execute();
        $entry = $result->fetch();

        // if no entry is found login fails
        if ($entry == false) {
            return false;
        }

        // checks the password against the password hash
        return (crypt($password, $entry[password]) == $entry[password]);
    }

    function checkActive($email)
    {
        $sql = 'SELECT activated FROM Users WHERE email=:email';
        $result = $this->dbconn->prepare($sql);
        $result->bindValue(':email', $email);
        $result->execute();
        $entry = $result->fetch();
        return $entry;

    }
}
    $username = $_POST['loginUsername'];
    $password = $_POST['loginPassword'];
    $login = new Login('Users');

    if(validate_login($username, $password)){
        if(checkActive($email)){
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
        }
        else
            header('Location: http://electricathletics.com/singuporin.php?error=2');
    }else
        header('Location: http://electricathletics.com/singuporin.php?error=1');

?>