<?php

    include("commentController.php");
    $articleID = $_POST['articleID'];
    $userID = $_POST['userID'];
    $comment = $_POST['commentText'];

    $commentController = new CommentController("comments");
    $commentController->addComment($userID,$articleID,$comment);
    header('Location: http://electricathletics.com/article.php?id=' . $articleID);

?>
