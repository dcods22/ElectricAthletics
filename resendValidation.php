<?php

    class EmailHandler
    {
        private $dbconn;
        private $table;

        function __construct($tablename, $dbname = 'blogdatabase', $dblogin = 'dancody', $dbpass = 'tino24', $url = 'electricathleticscom.ipagemysql.com')
        {
            $this->dbconn = new PDO("mysql:host=$url;dbname=$dbname", "$dblogin", "$dbpass");
            $this->tablename = $tablename;
        }

        function getEmail($ID){
            $sql = 'SELECT email FROM Users WHERE id=:id';
            $stmt = $this->dbconn->prepare( $sql );
            $stmt->bindValue(':ID', $ID);
            $stmt->execute();
            $entry = $stmt->fetch(PDO::FETCH_ASSOC);
            return($entry[email]);
        }

    }

    $emailHandler = new EmailHandler('Users');
    $ID = $_GET['id'];
    $subject = "Electric Athletics Validation";
    $headers = "From: noreply@electricathletics.com \r\n";
    $emailMessage = 'Click on the link to validate your Electric Athletics account.  http://electricathletics.com/validation.php?id=' . $ID .'
    $email = $emailHandler->getEmail($ID);
    mail($email, $subject, $emailMessage, $headers);
    header('Location: http://electricathletics.com/#/validate/' . $ID);

?>