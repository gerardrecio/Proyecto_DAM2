<?php
	$link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');
	
	if (mysqli_connect_error()) {
		$logMessage = 'MySQL Error: ' . mysqli_connect_error();

		echo $logMessage;
	}
	
		$idx = $_POST['taula'];
		$idx2 = trim($_POST['email_creador']);
		$idx3 = trim($_POST['email_bo']);

		$query = "select id from taulells WHERE (creador = '$idx2' and nom = '$idx')";

		$res = mysqli_query($link, $query);

		$row = mysqli_fetch_assoc($res);

		$idb = $row['id'];
		
		$query = "insert into taulell_usuaris (mail,id_taulell) values ('$idx3', '$idb')";
		
		$res = mysqli_query($link, $query);

		if (mysqli_affected_rows($link) > 0)
		{
			$queryxd = "insert into rols_usuaris_taulells (mail, id_rol, id_taulell) values ('$idx3', 3, '$idb')";
			mysqli_query($link, $queryxd);
			echo 1;
		}
		else
		{
			echo 0;
		}

	mysqli_close();

?>