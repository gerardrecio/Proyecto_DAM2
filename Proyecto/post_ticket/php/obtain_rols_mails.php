<?php
	$link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');
	
	if (mysqli_connect_error()) {
		$logMessage = 'MySQL Error: ' . mysqli_connect_error();

		echo $logMessage;
	}
	
		$idx = $_POST['tablero'];
		$idx2 = trim($_POST['creador']);

		$query = "select tu.mail as mailusu,rol.nom as nomrol from taulells as t left join taulell_usuaris as tu ON t.id = tu.id_taulell left join rols_usuaris_taulells as ru ON t.id = ru.id_taulell and  tu.mail = ru.mail left join rols as rol on ru.id_rol = rol.id WHERE (t.creador = '$idx2' and t.nom = '$idx')";

		$res = mysqli_query($link, $query);

		//echo $query;

		$myArr = array();   //array on tindrem tots els retorns en JSON

		while ( $row = mysqli_fetch_assoc($res) )
		{
			array_push($myArr, array('mailusu' => $row['mailusu'],'nomrol' => $row['nomrol']));
		}

		echo json_encode($myArr);

	mysqli_close();

?>