<?php
	$link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');
	
	if (mysqli_connect_error()) {
		$logMessage = 'MySQL Error: ' . mysqli_connect_error();

		echo $logMessage;
	}
	
		$idx = trim($_POST['nom_taulell']);
		$idx2 = trim($_POST['creador']);

		$query = "select c.nom from taulells as t inner join categories as c on t.id = c.id_taulells where t.nom = '$idx' and creador = '$idx2'";

		$res = mysqli_query($link, $query);

		//echo $query;

		$myArr = array();   //array on tindrem tots els retorns en JSON

		while ( $row = mysqli_fetch_assoc($res) )
		{
			array_push($myArr, array('nom' => $row['nom']));
		}

		echo json_encode($myArr);

	mysqli_close();

?>