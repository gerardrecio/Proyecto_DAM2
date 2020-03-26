<?php

    $xmessage = $_POST['message'];
    $xname = $_POST['name'];
    $xemail = $_POST['email'];
    $xsubject = $_POST['subject'];


    $headers = 'From: support@post-ticket.es';
    
    //envio de email
    mail($xemail,$xsubject,$xmessage,$headers);

    echo "1";
?>