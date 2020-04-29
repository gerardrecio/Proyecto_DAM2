<?php
	$link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');
	
	if (mysqli_connect_error()) {
		$logMessage = 'MySQL Error: ' . mysqli_connect_error();

		echo $logMessage;
	}
	
		$idx = trim($_POST['id_tasca']);

		$query = "select cos_missatge, creador, DATE_FORMAT(data_limit, '%d/%m/%Y') as data_limit from tasques where id = '$idx'";

		$res = mysqli_query($link, $query);

		//echo $query;

		$myArr = array();   //array on tindrem tots els retorns en JSON

		while ( $row = mysqli_fetch_assoc($res) )
		{
			array_push($myArr, array('creador' => $row['creador'],'cos_missatge' => $row['cos_missatge'],'data_limit' => $row['data_limit']));
		}

		echo json_encode($myArr);

	mysqli_close();

?>