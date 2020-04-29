<?php
	$link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');
	
	if (mysqli_connect_error()) {
		$logMessage = 'MySQL Error: ' . mysqli_connect_error();

		echo $logMessage;
	}
	
		$nom_taulell = $_POST['id_taulell'];
		$nom_creador = trim($_POST['creador']);

        $query = "select count(*) as tasques from tasques as ta inner join categories as ca on ta.id_categoria = ca.id inner join taulells as t on ca.id_taulells = t.id where t.creador = '$nom_creador' and t.nom = '$nom_taulell'";

        $resultat = mysqli_query($link, $query);

		$row = mysqli_fetch_assoc($resultat);
		
        echo $row["tasques"];

	mysqli_close();

?>