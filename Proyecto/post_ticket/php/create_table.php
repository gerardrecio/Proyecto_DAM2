<?php
    $link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');

    if (mysqli_connect_error()) {
        $logMessage = 'MySQL Error: ' . mysqli_connect_error();

        echo $logMessage;
    }

    //aqui comienza el codigo de crear la taula

    $nom_taula = trim($_POST['name_table']);
    $nom_correu = $_POST['correu'];


    $queryxd = "SELECT COUNT(*) AS Count FROM taulells WHERE nom = '$nom_taula' and creador = '$nom_correu'";

    $res = mysqli_query($link, $queryxd);

    $contabilizado = mysqli_fetch_assoc($res);

    if ($contabilizado['Count'] == 0)
    {
        $query = "INSERT INTO taulells (nom, creador, finalitzat) VALUES ('$nom_taula', '$nom_correu', 0)";

        //executem la query
        $result = mysqli_query($link, $query);
            
        echo 1;
    }
    else
    {
        echo 0;
    }

    mysqli_close();


?>