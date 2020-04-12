<?php

    //passem l'index (el correu) per obtenir tots els taulells en els que participara
    function obtain_total_incidencies($idx){

        $link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');

        //realitzem les operacions pertinents

        $query = "SELECT COUNT(id_taulell) AS Participants FROM taulell_usuaris WHERE mail = '$idx'";

        $resultat = mysqli_query($link, $query);

        $row = mysqli_fetch_assoc($resultat);

        //echo $row["Participants"];
        echo $row["Participants"];

        mysqli_close($link);
    }

    //passem l'index (el correu) per obtenir totes les incidencies a les que es participen
    function obtain_incidencies_mi($idx){
        
        $link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');
        //realitzem les operacions pertinents

        $query = "SELECT COUNT(id_taulell) AS Participants FROM taulell_usuaris WHERE mail = '$idx'";

        $resultat = mysqli_query($link, $query);

        $row = mysqli_fetch_assoc($resultat);

        //echo $row["Participants"];
        echo $row["Participants"];

        mysqli_close($link);
    }

?>