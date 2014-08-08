<?php

    include("php/changePassController.php");

    session_save_path("/home/users/web/b2834/ipg.electricathleticscom/sessions");
    session_start();

    if(isset($_SESSION['username'])){
        $username = $_SESSION['username'];
    }

    $PassController = new ChangePassController("Users");
    $info = $PassController->getUserInfo($username);
    $to = $info[email];
    $subject = 'Password Change';
    $number = $info[id] + 1234567;
    $email = "noreply@electricathletics.com";
    $headers = "From: $email \r\n";
    $message = '
        Here is the link to change your password \n
        \n
        http://electricathletics.com/changePass.php?id=' . $number;

    mail($to, $subject, $message, $headers);

    header("Location: http://electricathletics.com/changed.php?page=1");

?>