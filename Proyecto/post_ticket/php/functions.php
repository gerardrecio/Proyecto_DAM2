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

    function create_table_propierty($idx){

        $texto;

        $link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');
        //realitzem les operacions pertinents

        $query = "SELECT nom FROM taulells WHERE creador = '$idx'";

        $resultat = mysqli_query($link, $query);

        $myArr = array();


        while ($row = mysqli_fetch_assoc($resultat))
        {
            array_push($myArr, array('nom' => $row["nom"]));
        }

        foreach ($myArr as $valor){

            $nomArray = $valor['nom'];

            $texto.= "<li class='nav-item'><a class='nav-link' href='mydashboard.php'>$nomArray</a></li>";
        }

        echo $texto;

    }

    function create_conf_propierty($idx){

        $texto;

        $link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');
        //realitzem les operacions pertinents

        $query = "SELECT nom FROM taulells WHERE creador = '$idx'";

        $resultat = mysqli_query($link, $query);

        $myArr = array();


        while ($row = mysqli_fetch_assoc($resultat))
        {
            array_push($myArr, array('nom' => $row["nom"]));
        }

        foreach ($myArr as $valor){

            $nomArray = $valor['nom'];

            $texto.= "<li class='nav-item'><a class='nav-link' href='mydashboardconf.php'>$nomArray</a></li>";
        }

        echo $texto;

    }

    function create_table_shared($idx){

        $texto; //rango de ids a comparar con las , puestas
        $final;

        $link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');
        //realitzem les operacions pertinents

        //array per guardar les ids dels quals es propietary
        $myArr = array();
        //array per guardar els noms dels taulers del quals NO es propietary
        $myArrbo = array();

        $query = "SELECT id FROM taulells WHERE creador = '$idx'";

        $resultat = mysqli_query($link, $query);


        while ($row = mysqli_fetch_assoc($resultat))
        {
            array_push($myArr, array('id' => $row["id"]));
        }

        foreach ($myArr as $valor){

            $id = $valor['id']; //id!

            $texto.= $id.",";
        }

        $texto = rtrim($texto, ",");    //text sense la ultima ,

        $query_bona = "SELECT id_taulell FROM taulell_usuaris WHERE id_taulell NOT IN ($texto) AND mail='$idx'";   //busca tots els ids del taulell que NO estiguin al taulell

        
        $result = mysqli_query($link, $query_bona);

        while ($row = mysqli_fetch_assoc($result)){

            array_push($myArrbo, array('id' => $row["id_taulell"]));
        }

        $texto = "";

        foreach ($myArrbo as $valor){

            $id = $valor['id']; //id!

            $texto.= $id.",";
        }

        $texto = rtrim($texto, ",");    //text sense la ultima ,

        $query_final = "SELECT nom FROM taulells WHERE id IN ('$texto')";

        $resultat = mysqli_query($link, $query_final);

        $myArrx = array();

        while ($row = mysqli_fetch_assoc($resultat))
        {
            array_push($myArrx, array('nom' => $row["nom"]));
        }

        foreach ($myArrx as $valor){

            $nomArray = $valor['nom'];

            $final.= "<li class='nav-item'><a class='nav-link' href='mydashboard.php'>$nomArray</a></li>";
        }

        //aqui es te que eliminar l'ultima coma de el text*/

        echo $final;

    }

	//passem l'index (el correu) per obtenir totes els taulells creats per l'usuari
    function obtain_incidencies_creades($idx){
        
        $link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');
        //realitzem les operacions pertinents

        $query = "SELECT COUNT(id) AS Participants FROM taulells WHERE creador = '$idx'";

        $resultat = mysqli_query($link, $query);

        $row = mysqli_fetch_assoc($resultat);

        echo $row["Participants"];

        mysqli_close($link);
    }
	
	//passem l'index (el correu) per obtenir totes els taulells en procés
    function obtain_incidencies_proces($idx){
        
        $link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');
        //realitzem les operacions pertinents

        $query = "select count(*) as Participants from taulells as t left join taulell_usuaris as tu ON t.id = tu.id_taulell WHERE (t.creador = '$idx' or tu.mail = '$idx') and t.finalitzat = 0";

        $resultat = mysqli_query($link, $query);

        $row = mysqli_fetch_assoc($resultat);

        echo $row["Participants"];

        mysqli_close($link);
    }
	
	//passem l'index (el correu) per obtenir totes els taulells finalitzats
    function obtain_incidencies_finalitzat($idx){
        
        $link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');
        //realitzem les operacions pertinents

        $query = "select count(*) as Participants from taulells as t left join taulell_usuaris as tu ON t.id = tu.id_taulell WHERE (t.creador = '$idx' or tu.mail = '$idx') and t.finalitzat = 1";

        $resultat = mysqli_query($link, $query);

        $row = mysqli_fetch_assoc($resultat);

        echo $row["Participants"];

        mysqli_close($link);
    }
?>