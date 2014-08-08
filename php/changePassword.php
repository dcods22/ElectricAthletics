<?php

    include("changePassController.php");

    $password = $_POST['cpassword1'];
    $id = $_POST['id'];

    $changeController = new ChangePassController("Users");
    $password = crypt($password);
    $changeController->changePass($id, $password);

    header("Location: http://electricathletics.com/changed.php?page=2");

?>