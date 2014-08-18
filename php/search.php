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
    	$search = '%' . $search . '%';
    	$sql = "SELECT `id`, `typeID`, `pic`, `title` FROM `blogs` WHERE `title` LIKE :search";
    	$statement = $this->dbconn->prepare($sql);
		$statement->bindValue(':search', $search);
		$statement->execute();
		$entry = $statement->fetchall(PDO::FETCH_ASSOC);
		echo json_encode($entry);
    }

    function searchTags($search){
        $articles = array();
        $articlesFinal = array();

    	$search = '%' . $search . '%';
    	$sql = "SELECT `tagID` FROM `tagList` WHERE `tag` LIKE :search";
    	$statement = $this->dbconn->prepare($sql);
		$statement->bindValue(':search', $search);
		$statement->execute();
		$IDs = $statement->fetchall(PDO::FETCH_ASSOC);

		foreach($IDs as $ID){
            $sql2 = "SELECT `articleID` FROM `tags` WHERE tagID=:ID";
            $stmt = $this->dbconn->prepare($sql2);
            $stmt->bindValue(':ID', $ID[tagID]);
            $stmt->execute();
            $entry = $stmt->fetchall(PDO::FETCH_ASSOC);
            $articles = array_merge($articles, $entry);
	    }

        foreach($articles as $artID){
            $sql3 = "SELECT `id`, `typeID`,`pic`, `title` FROM `blogs` WHERE id=:artID";
            $stmt2 = $this->dbconn->prepare($sql3);
            $stmt2->bindValue(':artID', $artID[articleID]);
            $stmt2->execute();
            $art = $stmt2->fetchall(PDO::FETCH_ASSOC);
            $articlesFinal = array_merge($articlesFinal, $art);
        }

		echo json_encode($articlesFinal);
    }

    function searchUsers($search){
    	$search = '%' . $search . '%';
    	$sql = "SELECT `id`, `email`, `username`, `avatar` FROM `Users` WHERE `username` LIKE :search";
    	$statement = $this->dbconn->prepare($sql);
		$statement->bindValue(':search', $search);
		$statement->execute();
		$entry = $statement->fetchall(PDO::FETCH_ASSOC);
		echo json_encode($entry);
    }

}

$type = $_GET['type'];
$query = $_GET['query'];

$searchController = new SearchController('Users');

if($type == "article"){
    $searchController->searchArticles($query);
}else if($type == "tag"){
    $searchController->searchTags($query);
}else if($type == "user"){
    $searchController->searchUsers($query);
}



