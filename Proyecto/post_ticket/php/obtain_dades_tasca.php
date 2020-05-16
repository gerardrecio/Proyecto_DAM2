<?php
	$link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');
	
	if (mysqli_connect_error()) {
		$logMessage = 'MySQL Error: ' . mysqli_connect_error();

		echo $logMessage;
	}
	
		$idx = trim($_POST['id_tasca']);

		$query = "select ta.cos_missatge, ta.creador, DATE_FORMAT(ta.data_limit, '%d/%m/%Y') as data_limit, es.descripcio, ta.asignat, ca.nom, if(DATE_FORMAT(ta.data_limit, '%Y/%m/%d') < DATE_FORMAT(NOW(), '%Y/%m/%d'), '0','1') as data_valor from tasques as ta inner join estats as es on ta.estat = es.id inner join categories as ca on ta.id_categoria = ca.id where ta.id = '$idx'";

		$res = mysqli_query($link, $query);

		//echo $query;

		$myArr = array();   //array on tindrem tots els retorns en JSON

		while ( $row = mysqli_fetch_assoc($res) )
		{
			array_push($myArr, array('creador' => $row['creador'],'cos_missatge' => $row['cos_missatge'],'data_limit' => $row['data_limit'],'descripcio' => $row['descripcio'],'asignat' => $row['asignat'],'nom' => $row['nom'],'data_valor' => $row['data_valor']));
		}

		echo json_encode($myArr);

	mysqli_close();

?>