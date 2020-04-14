<?php
    session_unset();
    session_destroy();
    setcookie("PHPSESSID","",0,"/");
    header('Location: http://post-ticket.es');
?>