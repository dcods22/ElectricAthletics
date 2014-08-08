<?php

class BlogUpdate
{
    private $dbconn;
    private $tablename;

    function __construct($tablename, $dbname = 'blogdatabase', $dblogin = 'dancody', $dbpass = 'tino24', $url = 'electricathleticscom.ipagemysql.com')
    {
        $this->dbconn = new PDO("mysql:host=$url;dbname=$dbname", "$dblogin", "$dbpass");
        $this->tablename = $tablename;
    }

    function updatePost($ID, $typeID, $title, $desc, $article, $pic, $picDesc, $picSrc){
        // build INSERT query string
        $sql = 'UPDATE `blogs` SET `typeID`=:typeID, `title`=:title, `desc`=:desc, `article`=:article, `pic`=:pic, `picDesc`=:picDesc, `picSrc`=:picDesc WHERE id=:id';

        $stmt = $this->dbconn->prepare( $sql );
        $stmt->bindValue(':id', $ID);
        $stmt->bindValue(':typeID', $typeID);
        $stmt->bindValue(':title', $title);
        $stmt->bindValue(':desc', $desc);
        $stmt->bindValue(':article', $article);
        $stmt->bindValue(':pic', $pic);
        $stmt->bindValue(':picDesc', $picDesc);
        $stmt->bindValue(':picSrc', $picSrc);

        $stmt->execute();
    }

    function addTagList($tag){
        // build INSERT query string
        $sql = 'INSERT INTO `tagList` ( `tag` ) VALUES ( :tag )';
        $stmt = $this->dbconn->prepare( $sql );
        $stmt->bindValue(':tag', $tag);
        $stmt->execute();
    }


    function addTags($tagID, $articleID){
            // build INSERT query string
        $sql = 'INSERT INTO `tags` ( `tagID`, `articleID`) VALUES ( :tagID, :articleID )';
        $stmt = $this->dbconn->prepare( $sql );
        $stmt->bindValue(':tagID', $tagID);
        $stmt->bindValue(':articleID', $articleID);
        $stmt->execute();

    }

    function getTagID($tag){
        $sql = 'SELECT `tagID` FROM tagList WHERE tag=:tag';

        $stmt = $this->dbconn->prepare( $sql );
        $stmt->bindValue(':tag', $tag);
        $stmt->execute();
        $entry =  $stmt->fetch(PDO::FETCH_ASSOC);
        return ($entry[tagID]);
    }

    function getArticleID($title){
        $sql = 'SELECT `id` FROM `blogs` WHERE title=:title';

        $stmt = $this->dbconn->prepare( $sql );
        $stmt->bindValue(':title', $title);
        $stmt->execute();
        $entry =  $stmt->fetch(PDO::FETCH_ASSOC);
        return ($entry[id]);
    }

    function deleteExistingTags($articleID){
        $sql = 'DELETE FROM `tags` WHERE articleID=:articleID';
        $statement = $this->dbconn->prepare( $sql );
        $statement->bindValue(':articleID', $articleID);
        $statement->execute();
    }


}

$blogUpdate = new BlogUpdate("blogs");
$ID = $_POST['id'];
$typeID = $_POST['addType'];
$title = $_POST['addTitle'];
$desc = $_POST['addDesc'];
$article = $_POST['addArticle'];
$pic = $_POST['addPic'];
$picDesc = $_POST['addPicDesc'];
$picSrc = $_POST['addPicSrc'];
$blogUpdate->deleteExistingTags($ID);

if(!empty($_POST['tags'])) {
    foreach ($_POST['tags'] as $tag):
        $blogUpdate->addTags($tag, $ID);
    endforeach;
}

//parse string and add to tag list then add tag
if(!empty($_POST['tagOther'])) {
    $newTags = $_POST['tagOther'];
    $newTagList = explode(",", $newTags);

    foreach ($newTagList as $newTagPre):
        $newTag = trim($newTagPre);
        $blogUpdate->addTagList($newTag);
        $newTagID = $blogUpdate->getTagID($newTag);
        $blogUpdate->addTags($newTagID, $ID);
    endforeach;
}

$blogUpdate->updatePost($ID, $typeID, $title, $desc, $article, $pic, $picDesc, $picSrc);
header('Location: http://www.electricathletics.com/article.php?id=' . $ID);

?>