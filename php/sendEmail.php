<?php

    $emailInfo = file_get_contents("php://input");
    $emails = json_decode($emailInfo);

    $to = 'miniposada20@gmail.com';
    $subject = 'Message from ElectricAthletics.com';
    $message = $emails->message;
    $name = $emails->name;
    $email = $emails->email;

    $headers = "From: $email \r\n";
    mail($to, $subject, $message, $headers);
?>