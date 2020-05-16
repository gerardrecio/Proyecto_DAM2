<?php
	$link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');
	
	if (mysqli_connect_error()) {
		$logMessage = 'MySQL Error: ' . mysqli_connect_error();

		echo $logMessage;
	}
	
		$idx = trim($_POST['id_taulell']);
		$idx2 = trim($_POST['creador']);
		$idx3 = trim($_POST['usuari']);

		$query = "select id_rol from rols_usuaris_taulells where id_taulell = (select id from taulells where nom = '$idx' and creador = '$idx2') and mail = '$idx3'";

		$res = mysqli_query($link, $query);

		//echo $query;
		
		$row = mysqli_fetch_assoc($res);
		
		$var = $row['id_rol'];
		
		echo $var;
/*
		$myArr = array();   //array on tindrem tots els retorns en JSON

		while ( $row = mysqli_fetch_assoc($res) )
		{
			array_push($myArr, array('nom' => $row['nom']));
		}

		echo json_encode($myArr);
*/
	mysqli_close();

?>