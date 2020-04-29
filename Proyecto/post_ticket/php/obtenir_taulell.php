<?php
	$link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');
	
	if (mysqli_connect_error()) {
		$logMessage = 'MySQL Error: ' . mysqli_connect_error();

		echo $logMessage;
	}
	
		$idx = $_POST['id_taulell'];
		$idx2 = trim($_POST['creador']);

		$query = "select ta.id,ta.titol,ca.nom as categoria,ta.asignat,DATE_FORMAT(ta.data_limit, '%d-%m-%Y') as data_limit,est.descripcio as estat,ta.estat as color from tasques as ta inner join categories as ca on ta.id_categoria = ca.id inner join taulells as t on ca.id_taulells = t.id inner join estats as est on ta.estat = est.id where t.nom = '$idx' and t.creador = '$idx2' and ta.estat <> 3 order by id asc";

		$res = mysqli_query($link, $query);

		//echo $query;

		$myArr = array();   //array on tindrem tots els retorns en JSON

		while ( $row = mysqli_fetch_assoc($res) )
		{
			array_push($myArr, array('titol' => $row['titol'],'categoria' => $row['categoria'],'asignat' => $row['asignat'],'data_limit' => $row['data_limit'],'estat' => $row['estat'],'id' => $row['id'],'color' => $row['color']));
		}

		echo json_encode($myArr);

	mysqli_close();

?>