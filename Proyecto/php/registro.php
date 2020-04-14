<?php

$link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');

    if (mysqli_connect_error()) {
        $logMessage = 'MySQL Error: ' . mysqli_connect_error();

        echo $logMessage;
    }

    //aqui comienza el codigo de registro de usuario

    $email = $_POST['email'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $password = $_POST['password'];

    $pwdcrypt = password_hash($password, PASSWORD_BCRYPT);

    $query = "INSERT INTO usuaris (mail, nom, cognom, pwd, administrador) VALUES ('$email', '$name', '$surname', '$pwdcrypt', '0')";

    $xcompare = mysqli_query($link, $query);

    if ($xcompare == true)
    {
        echo 1;
    }
    else
    {
        echo 0;
    }

    mysqli_close($link);
 
?>