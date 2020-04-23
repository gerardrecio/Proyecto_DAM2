<?php
    $link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');

    if (mysqli_connect_error()) {
        $logMessage = 'MySQL Error: ' . mysqli_connect_error();

        echo $logMessage;
    }

    $email = $_POST['mailto'];
    $rolid = $_POST['rol'];
    $nom_taulell = $_POST['nom_tau'];
    $nom_creador = trim($_POST['mailcreador']);

        $query = "SELECT id FROM taulells WHERE creador = '$nom_creador' and nom = '$nom_taulell'";

        $res = mysqli_query($link, $query);

        $tp = mysqli_fetch_assoc($res);

        $id_bona = $tp['id'];

        $queryxd = "UPDATE rols_usuaris_taulells SET id_rol = '$rolid' WHERE mail = '$email' AND id_taulell = '$id_bona'";

        mysqli_query($link, $queryxd);

        if (mysqli_affected_rows($link) > 0)
        {
            echo 1;
        }
        else
        {
            echo 0;
        }
       
    mysqli_close();

?>