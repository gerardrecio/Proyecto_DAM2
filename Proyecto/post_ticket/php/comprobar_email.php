<?php
    $link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');

    if (mysqli_connect_error()) {
        $logMessage = 'MySQL Error: ' . mysqli_connect_error();

        echo $logMessage;
    }

    //aqui comienza el codigo de crear la taula

    $nom_creador = trim($_POST['creador']); //email del creador
    $nom_taulell = $_POST['taulell'];   //nom del taulell
    $nom_email = trim($_POST['email']); //email de qui volem afegir


    if (strcmp($nom_creador, $nom_email) == 0)
    {
        $arr = array('Resposta' => 0, 'email' => $nom_email);
    }
    else
    {

        $querp = "SELECT COUNT(*) AS Existeix FROM usuaris WHERE mail = '$nom_email'";

        $reste = mysqli_query($link, $querp);

        $conti = mysqli_fetch_assoc($reste);

        if ($conti['Existeix'] == 0)
        {
            $arr = array('Resposta' => 0, 'email' => $nom_email);
        }
        else
        {
            $queryxd = "SELECT id FROM taulells WHERE nom = '$nom_taulell' and creador = '$nom_creador' ";

            $res = mysqli_query($link, $queryxd);
        
            $cont = mysqli_fetch_assoc($res);
        
            $id_taula = $cont['id'];
        
            $query = "SELECT COUNT(*) AS Trobat FROM taulell_usuaris WHERE mail = '$nom_email' and id_taulell = '$id_taula'";
        
            $rest = mysqli_query($link, $query);
        
            $contabilizado = mysqli_fetch_assoc($rest);
        
        
            if ($contabilizado['Trobat'] == 0)
            {
                $arr = array('Resposta' => 1, 'email' => $nom_email);
            }
            else
            {
                $arr = array('Resposta' => 0, 'email' => $nom_email);
            }
        }
    }

    echo json_encode($arr);

    mysqli_close();

?>