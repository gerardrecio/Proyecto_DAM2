<?php
	$link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');
	
	if (mysqli_connect_error()) {
		$logMessage = 'MySQL Error: ' . mysqli_connect_error();

		echo $logMessage;
	}
	
		$idx = trim($_POST['correo']);

		$query = "select t.nom,count(ta.titol) as contador from taulells as t inner join categories as ca on t.id = ca.id_taulells inner join tasques as ta on ca.id = ta.id_categoria inner join taulell_usuaris as tu on t.id = tu.id_taulell group by t.nom, t.creador, tu.mail having creador = '$idx' or tu.mail = '$idx'";

		$res = mysqli_query($link, $query);

		//echo $query;

		$myArr = array();   //array on tindrem tots els retorns en JSON

		while ( $row = mysqli_fetch_assoc($res) )
		{
			array_push($myArr, array('nom' => $row['nom'],'contador' => $row['contador']));
		}

		echo json_encode($myArr);

	mysqli_close();

?>