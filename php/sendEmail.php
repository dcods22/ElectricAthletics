<?php
    $to = 'daniel.cody2@marist.edu';
    $subject = 'Message from ElectricAthletics.com';
    $message = $_POST['formBody'];
    $name = $_POST['formName'];
    $email = $_POST['formEmail'];
    $headers = "From: $email \r\n";
    mail($to, $subject, $message, $headers);
    header('Location: http://www.electricathletics.com/thanks.php');
?>