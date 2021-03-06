<?php

	class BlogController
	{
		private $dbconn;
		private $tablename;
		
		function __construct($tablename, $dbname = 'blogdatabase', $dblogin = 'dancody', $dbpass = 'tino24', $url = 'electricathleticscom.ipagemysql.com')
		{
			$this->dbconn = new PDO("mysql:host=$url;dbname=$dbname", "$dblogin", "$dbpass");
			$this->tablename = $tablename;
		}

		function getPostInfo($postID){
	   		//build query string
	    	$sql = 'SELECT * FROM ' . $this->tablename . ' WHERE id=:postID';
	    	// submit database query
	    	$stmt = $this->dbconn->prepare( $sql );
			$stmt->bindValue(':postID', $postID);
	    	$stmt->execute();
			$entry = $stmt->fetch(PDO::FETCH_ASSOC);
			echo json_encode($entry);
		}

		function getAllPosts(){
			// build query string
	    	$sql = 'SELECT * FROM ' . $this->tablename . ' ORDER BY time DESC';

	    	// submit database query
	    	$stmt = $this->dbconn->prepare( $sql );
	    	$stmt->execute();
			$entry = $stmt->fetchAll(PDO::FETCH_ASSOC);
			echo json_encode($entry);
		}

		function getSportPosts(){
            // build query string
            $sql = 'SELECT * FROM ' . $this->tablename . ' WHERE typeID=2 ORDER BY time DESC';

            // submit database query
            $stmt = $this->dbconn->prepare( $sql );
            $stmt->execute();
            $entry = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($entry);
		}

		function getTechPosts(){
			// build query string
	    	$sql = 'SELECT * FROM ' . $this->tablename . ' WHERE typeID=1 ORDER BY time DESC';

	    	// submit database query
	    	$stmt = $this->dbconn->prepare( $sql );
	    	$stmt->execute();
			$entry = $stmt->fetchAll(PDO::FETCH_ASSOC);
			echo json_encode($entry);
		}

		function getArticleTags($articleID){
			$sql = 'SELECT tagID FROM tags WHERE articleID=:articleID';
			$stmt = $this->dbconn->prepare( $sql );
			$stmt->bindValue(':articleID', $articleID);
	    	$stmt->execute();
			$entry = $stmt->fetchall(PDO::FETCH_ASSOC);
			echo json_encode($entry);
		}

		function getTagName($tagID){
			$sql = 'SELECT tag FROM tagList WHERE tagID=:tagID';
			$stmt = $this->dbconn->prepare( $sql );
			$stmt->bindValue(':tagID', $tagID);
	    	$stmt->execute();
			$entry = $stmt->fetch(PDO::FETCH_ASSOC);
			echo json_encode($entry[tag]);
		}
	
	}

    $blogController = new BlogController('blogs');
	$type = $_GET['type'];

	if($type == "all"){
        $blogController->getAllPosts();

	}elseif($type == "sports"){
	    $blogController->getSportPosts();

	}elseif($type == "technology"){
	    $blogController->getTechPosts();

	}else if($type == "article"){
	    $ID = $_GET['id'];
	    $blogController->getPostInfo($ID);
	}
?>


