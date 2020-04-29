<?php
	$link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');
	
	if (mysqli_connect_error()) {
		$logMessage = 'MySQL Error: ' . mysqli_connect_error();

		echo $logMessage;
	}
	
		$idx = $_POST['id_tasca'];
		$idx2 = trim($_POST['creador']);

		$query = "select email as mail,DATE_FORMAT(fecha, '%d/%m/%Y %H:%i') as fecha,missatge, '1' as valor from missatges_tasques where id_tasca = '$idx' and email <> '$idx2' union select email as mail,DATE_FORMAT(fecha, '%d/%m/%Y %H:%i') as fecha,missatge, '0' as valor from missatges_tasques where id_tasca = '$idx' and email = '$idx2' order by fecha asc";

		$res = mysqli_query($link, $query);

		//echo $query;

		$myArr = array();   //array on tindrem tots els retorns en JSON

		while ( $row = mysqli_fetch_assoc($res) )
		{
				array_push($myArr, array('mail' => $row['mail'],'fecha' => $row['fecha'],'missatge' => $row['missatge'],'valor' => $row['valor']));
		}

		echo json_encode($myArr);

	mysqli_close();

?>