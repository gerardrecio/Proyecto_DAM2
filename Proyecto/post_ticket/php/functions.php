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

            $texto.= "<li class='nav-item'><a class='nav-link' href='mydashboard.php?id_taulell=$nomArray'>$nomArray</a></li>";
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

            $texto.= "<li class='nav-item'><a class='nav-link' href='mydashboardconf.php?id_taulell=$nomArray'>$nomArray</a></li>";
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

            $final.= "<li class='nav-item'><a class='nav-link' href='mydashboard.php?id_taulell=$nomArray'>$nomArray</a></li>";
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

        $query = "select count(*) as Participants from taulells where creador = '$idx' and finalitzat = 0";
        $query2 = "select count(*) as Participants from taulell_usuaris as tu inner join taulells as t ON t.id = tu.id_taulell where mail = '$idx' and t.finalitzat = 0";

        $resultat = mysqli_query($link, $query);
        $resultat2 = mysqli_query($link, $query2);

        $row = mysqli_fetch_assoc($resultat);
        $row2 = mysqli_fetch_assoc($resultat2);
		
		$valor = $row["Participants"] + $row2["Participants"];

        echo $valor;

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
	
	//obtenir nom i cognom concatenats a partir del mail
    function obtain_nom_cognom($idx){
        
        $link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');
        //realitzem les operacions pertinents

        $query = "select concat(concat(nom,' '),cognom) AS Participants from usuaris WHERE mail = '$idx'";

        $resultat = mysqli_query($link, $query);

        $row = mysqli_fetch_assoc($resultat);

        echo $row["Participants"];

        mysqli_close($link);
    }

    //obtenir nom i cognom concatenats a partir del mail
    function obtain_nom_taulell_get_conf($idx){

        echo "Taulell: ".$idx;
    }

    	//obtenir nom i cognom concatenats a partir del mail
    function return_nom_cognom($idx){
        
        $link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');
        //realitzem les operacions pertinents

        $query = "select concat(concat(nom,' '),cognom) AS Participants from usuaris WHERE mail = '$idx'";

        $resultat = mysqli_query($link, $query);

        $row = mysqli_fetch_assoc($resultat);

        return $row["Participants"];

        mysqli_close($link);
    }
	
	//passem l'index (el correu) per obtenir totes les tasques creades per l'usuari
    function obtain_tasques_creades($idx){
        
        $link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');
        //realitzem les operacions pertinents

        $query = "SELECT COUNT(*) AS Participants FROM tasques_usuaris WHERE mail_usuari = '$idx'";

        $resultat = mysqli_query($link, $query);

        $row = mysqli_fetch_assoc($resultat);

        echo $row["Participants"];

        mysqli_close($link);
    }
	
	//passem l'index (el correu) per obtenir totes les tasques pendents assignades a l'usuari
    function obtain_tasques_pendents_asignades($idx){
        
        $link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');
        //realitzem les operacions pertinents

        $query = "SELECT COUNT(*) AS Participants FROM tasques WHERE asignat = '$idx' and estat = 1";

        $resultat = mysqli_query($link, $query);

        $row = mysqli_fetch_assoc($resultat);

        echo $row["Participants"];

        mysqli_close($link);
    }
	
	//passem l'index (el correu) per obtenir totes les tasques en procés assignades a l'usuari
    function obtain_tasques_proces_asignades($idx){
        
        $link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');
        //realitzem les operacions pertinents

        $query = "SELECT COUNT(*) AS Participants FROM tasques WHERE asignat = '$idx' and estat = 2";

        $resultat = mysqli_query($link, $query);

        $row = mysqli_fetch_assoc($resultat);

        echo $row["Participants"];

        mysqli_close($link);
    }
	
	//passem l'index (el correu) per obtenir totes les tasques finalitzades assignades a l'usuari
    function obtain_tasques_finalitzades_asignades($idx){
        
        $link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');
        //realitzem les operacions pertinents

        $query = "SELECT COUNT(*) AS Participants FROM tasques WHERE asignat = '$idx' and estat = 3";

        $resultat = mysqli_query($link, $query);

        $row = mysqli_fetch_assoc($resultat);

        echo $row["Participants"];

        mysqli_close($link);
    }
	
		//passem l'index (el correu) per obtenir totes els taulells que participa
    function obtain_taulells_participats($idx){
        
        $link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');
        //realitzem les operacions pertinents

        $query = "select count(*) as Participants from taulells where creador = 'perichors@gmail.com'";
		$query2 = "select count(*) as Participants from taulell_usuaris where mail = 'perichors@gmail.com'";

        $resultat = mysqli_query($link, $query);
		$resultat2 = mysqli_query($link, $query2);

        $row = mysqli_fetch_assoc($resultat);
		$row2 = mysqli_fetch_assoc($resultat2);

		$valor = $row["Participants"] + $row2["Participants"];

        echo $valor;

        mysqli_close($link);
    }
	
	//passem l'index (el correu) per obtenir totes les tasques dels taulells que participa
    function obtain_total_tasques_per_usuari($idx){
        
        $link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');
        //realitzem les operacions pertinents

        $query = "select distinct count(ta.id) AS tasques from taulells as t inner join taulell_usuaris as tu ON t.id = tu.id_taulell inner join categories as ca ON t.id = ca.id_taulells inner join tasques as ta ON ca.id = ta.id_categoria group by t.creador, tu.mail HAVING  (t.creador = '$idx' or tu.mail = '$idx')";

        $resultat = mysqli_query($link, $query);

        $row = mysqli_fetch_assoc($resultat);

        echo $row["tasques"];

        mysqli_close($link);
    }
	
	//passem l'index (el correu) per obtenir totes les tasques dels taulells que participa
    function obtain_total_tasques_creades_usuari($idx){
        
        $link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');
        //realitzem les operacions pertinents

        $query = "select distinct count(ta.id) AS tasques from taulells as t inner join taulell_usuaris as tu ON t.id = tu.id_taulell inner join categories as ca ON t.id = ca.id_taulells inner join tasques as ta ON ca.id = ta.id_categoria group by t.creador, tu.mail HAVING  (t.creador = '$idx')";

        $resultat = mysqli_query($link, $query);

        $row = mysqli_fetch_assoc($resultat);

		if($row["tasques"] == "" or $row["tasques"] == null)
		{
			echo 0;
		}
		else
		{
			echo $row["tasques"];
		}

        mysqli_close($link);
    }
	
	//passem l'index (el correu) per obtenir totes les tasques dels taulells que participa
    function obtain_total_tasques_assignades_usuari($idx){
        
        $link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');
        //realitzem les operacions pertinents

        $query = "select count(*) as tasques from tasques WHERE (asignat = '$idx')";

        $resultat = mysqli_query($link, $query);

        $row = mysqli_fetch_assoc($resultat);

        echo $row["tasques"];

        mysqli_close($link);
    }
	
	//obtenir total tasques taulells
    function obtain_total_tasques_taulell($idx, $idx2){

        //echo $idx;
		
		$link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');
        //realitzem les operacions pertinents

        $query = "select count(*) as tasques from tasques as ta inner join categories as ca on ta.id_categoria = ca.id inner join taulells as t on ca.id_taulells = t.id where t.creador = '$idx2' and t.nom = '$idx'";

        $resultat = mysqli_query($link, $query);

        $row = mysqli_fetch_assoc($resultat);

        echo $row["tasques"];

        mysqli_close($link);
    }
	
	//obtenir tasques pendents
    function obtain_pendent_tasques_taulell($idx, $idx2){

        //echo $idx;
		
		$link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');
        //realitzem les operacions pertinents

        $query = "select count(*) as tasques from tasques as ta inner join categories as ca on ta.id_categoria = ca.id inner join taulells as t on ca.id_taulells = t.id where t.creador = '$idx2' and t.nom = '$idx' and ta.estat = 1";

        $resultat = mysqli_query($link, $query);

        $row = mysqli_fetch_assoc($resultat);

        echo $row["tasques"];

        mysqli_close($link);
    }
	
	//obtenir tasques proces
    function obtain_proces_tasques_taulell($idx, $idx2){

        //echo $idx;
		
		$link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');
        //realitzem les operacions pertinents

        $query = "select count(*) as tasques from tasques as ta inner join categories as ca on ta.id_categoria = ca.id inner join taulells as t on ca.id_taulells = t.id where t.creador = '$idx2' and t.nom = '$idx' and ta.estat = 2";

        $resultat = mysqli_query($link, $query);

        $row = mysqli_fetch_assoc($resultat);

        echo $row["tasques"];

        mysqli_close($link);
    }
	
	//obtenir tasques finalit
    function obtain_finalitzades_tasques_taulell($idx, $idx2){

        //echo $idx;
		
		$link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');
        //realitzem les operacions pertinents

        $query = "select count(*) as tasques from tasques as ta inner join categories as ca on ta.id_categoria = ca.id inner join taulells as t on ca.id_taulells = t.id where t.creador = '$idx2' and t.nom = '$idx' and ta.estat = 3";

        $resultat = mysqli_query($link, $query);

        $row = mysqli_fetch_assoc($resultat);

        echo $row["tasques"];

        mysqli_close($link);
    }
	
	//obtenir tasques inici
    function obtain_tasques_inici_taula($idx){

        //echo $idx;
		
		$link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');
        //realitzem les operacions pertinents

        $query = "select distinct t.nom as nomtaulell, ta.titol as nomtasca, ca.nom as nomcat, ta.asignat, est.descripcio as estat, ta.data_limit as datalimit, ta.estat from taulells as t left join taulell_usuaris as tu ON t.id = tu.id_taulell left join categories as ca ON t.id = ca.id_taulells inner join tasques as ta ON ca.id = ta.id_categoria left join estats as est ON ta.estat = est.id WHERE (t.creador = '$idx' or tu.mail = '$idx') and ta.titol is not null and ta.estat <> 3  order by data_limit desc";

        $resultat = mysqli_query($link, $query);
		$index = 1;

		while($row = mysqli_fetch_row($resultat))
		{
			echo "<tr>";
			echo "<td>$index</td>";
			echo "<td>$row[0]</td>";
			echo "<td>$row[1]</td>";
			echo "<td>$row[2]</td>";
			echo "<td>$row[3]</td>";
			echo "<td>";
			if($row[6] == 2)
			{
				echo "<span class='badge-dot badge-success mr-1'></span>";
			}
			else if($row[6] == 3)
			{
				
			}
			else if($row[6] == 1)
			{
				echo "<span class='badge-dot badge-brand mr-1'></span>";
			}
			echo "$row[4]";
			echo "</td>";
			echo "<td>$row[5]</td>";
			echo "</tr>";
			$index = $index +1;
		}

        mysqli_close($link);
    }

    function obtenir_nom_taulell_GET()
    {
        return $_GET['id_taulell'];
    }
	
	//obtenir total tasques del taulell en concret
	function obtain_tasques_taulell_propi($idx,$idx2){
		
		$link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');

        $query = "select count(*) as tasques from tasques as ta inner join categories as ca on ta.id_categoria = ca.id inner join taulells as t on ca.id_taulells = t.id where t.nom = '$idx2' and t.creador = '$idx'";

        $resultat = mysqli_query($link, $query);

        $row = mysqli_fetch_assoc($resultat);

        echo $row["tasques"];

        mysqli_close($link);
	}
	
?>
