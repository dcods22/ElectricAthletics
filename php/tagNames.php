<?php

	class TagNameController
	{
		private $dbconn;
		private $tablename;

		function __construct($tablename, $dbname = 'blogdatabase', $dblogin = 'dancody', $dbpass = 'tino24', $url = 'electricathleticscom.ipagemysql.com')
		{
			$this->dbconn = new PDO("mysql:host=$url;dbname=$dbname", "$dblogin", "$dbpass");
			$this->tablename = $tablename;
		}

		function getTagList(){
            $sql = 'SELECT * FROM tagList';
            $stmt = $this->dbconn->prepare( $sql );
            $stmt->execute();
            $entry =  $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($entry);
        }

    }


    $tagNameController = new TagNameController('tags');
    $tagNameController->getTagList();

?>