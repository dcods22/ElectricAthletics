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
			return($entry);
		}

		function getAllPosts(){
			// build query string
	    	$sql = 'SELECT `id`,`typeID`,`title`,`time`,`desc`,`pic` FROM ' . $this->tablename;

	    	// submit database query
	    	$stmt = $this->dbconn->prepare( $sql );
	    	$stmt->execute();
			$entry = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return($entry);
		}

		function getSportPosts(){
            // build query string
            $sql = 'SELECT `id`,`typeID`,`title`,`time`,`desc`,`pic` FROM ' . $this->tablename . ' WHERE typeID=2';

            // submit database query
            $stmt = $this->dbconn->prepare( $sql );
            $stmt->execute();
            $entry = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return($entry);
		}

		function getTechPosts(){
			// build query string
	    	$sql = 'SELECT `id`,`typeID`,`title`,`time`,`desc`,`pic` FROM ' . $this->tablename . ' WHERE typeID=1';

	    	// submit database query
	    	$stmt = $this->dbconn->prepare( $sql );
	    	$stmt->execute();
			$entry = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return($entry);
		}

        function addPost($typeID, $title, $desc, $article, $pic, $picDesc, $picSrc){
            // build INSERT query string
            $sql = 'INSERT INTO ' . $this->tablename . ' (typeID, title, desc, article, pic, picDesc, picSrc)
					VALUES ( :typeID, :title, :desc, :article, :pic, :picDesc, :picSrc )';

            $stmt = $this->dbconn->prepare( $sql );
            $stmt->bindValue(':typeID', $typeID);
            $stmt->bindValue(':title', $title);
            $stmt->bindValue(':desc', $desc);
            $stmt->bindValue(':article', $article);
            $stmt->bindValue(':pic', $pic);
            $stmt->bindValue(':picDesc', $picDesc);
            $stmt->bindValue(':picSrc', $picSrc);
            $stmt->execute();
        }
	
	}
?>


