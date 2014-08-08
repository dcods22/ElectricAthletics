<?php 

class SearchController
{
    private $dbconn;
    private $table;

    function __construct($tablename, $dbname = 'blogdatabase', $dblogin = 'dancody', $dbpass = 'tino24', $url = 'electricathleticscom.ipagemysql.com')
    {
        $this->dbconn = new PDO("mysql:host=$url;dbname=$dbname", "$dblogin", "$dbpass");
        $this->tablename = $tablename;
    }

    function searchArticles($search){
    	$search = '%' + $search + '%';
    	$sql = "SELECT * FROM `blogs` WHERE `title` LIKE :search";
    	$statement = $this->dbconn->prepare($sql);
		$statement->bindValue(':search', $search);
		$statement->execute();
		$entry = $statement->fetchall(PDO::FETCH_ASSOC);
		return($entry);
    }

    function searchTags($search){
    	$search = '%' + $search + '%';
    	$sql = "SELECT `tagID` FROM `tagList` WHERE `tag` LIKE :search";
    	$statement = $this->dbconn->prepare($sql);
		$statement->bindValue(':search', $search);
		$statement->execute();
		$IDs = $statement->fetchall(PDO::FETCH_ASSOC);

		foreach($IDs as $ID):
            $sql2 = "SELECT `articleID` FROM `tags` WHERE tagID=:ID";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->bindValue(':search', $search);
            $stmt->execute();
            $articles = $stmt->fetchall(PDO::FETCH_ASSOC);
            array_push($entry, $articles);    
		endforeach;

		return($entry);
    }

    function searchUsers($search){
    	$search = '%' + $search + '%';
    	$sql = "SELECT * FROM `Users` WHERE `username` LIKE :search";
    	$statement = $this->dbconn->prepare($sql);
		$statement->bindValue(':search', $search);
		$statement->execute();
		$entry = $statement->fetchall(PDO::FETCH_ASSOC);
		return($entry);
    }

}




