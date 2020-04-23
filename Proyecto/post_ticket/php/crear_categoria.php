<?php
	$link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');
	
	if (mysqli_connect_error()) {
		$logMessage = 'MySQL Error: ' . mysqli_connect_error();

		echo $logMessage;
	}
	
		$idx = $_POST['taulell'];
		$idx2 = $_POST['categoria'];
		$idx3 = trim($_POST['creador']);

		$query = "select count(*) as contador from taulells as t inner join categories as ca ON t.id = ca.id_taulells where t.nom = '$idx' and t.creador = '$idx3' and ca.nom = '$idx2'";

		$resultat = mysqli_query($link, $query);

		$row = mysqli_fetch_assoc($resultat);

		$contador = $row['contador'];

		if ($contador==0)
		{
			$query2 = "select id from taulells where nom = '$idx' and creador = '$idx3' limit 1";
			
			$resultat = mysqli_query($link, $query2);

			$row = mysqli_fetch_assoc($resultat);

			$idtaula = $row['id'];
			
			
			
			$query3 = "insert into categories (nom, id_taulells) values ('$idx2', '$idtaula')";
			
			$row = mysqli_query($link, $query3);
		
			if ($row == true)
			{
				echo 1;
			}
			else
			{
				echo 0;
			}
			
		}

	mysqli_close();

?>