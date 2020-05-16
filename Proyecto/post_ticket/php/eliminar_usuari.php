<?php
	$link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');
	
	if (mysqli_connect_error()) {
		$logMessage = 'MySQL Error: ' . mysqli_connect_error();

		echo $logMessage;
	}
	
		$idx = trim($_POST['mail']);
		$idx2 = $_POST['taulell'];
		$idx3 = trim($_POST['creador']);

		$query = "select id from taulells where creador = '$idx3' and nom = '$idx2'";

		$resultat = mysqli_query($link, $query);

		$row = mysqli_fetch_assoc($resultat);

		$idtaula = $row['id'];

		$query2 = "delete FROM taulell_usuaris where id_taulell = '$idtaula' and mail = '$idx'";

		$row = mysqli_query($link, $query2);
		
		if ($row == true)
		{
			echo 1;
		}
		else
		{
			echo 0;
		}
		
		$query3 = "select count(*) as contador from categories as ca inner join tasques as ta ON ta.id_categoria = ca.id where ca.id_taulells = '$idtaula' and ta.asignat = '$idx'";
		
		$resultat = mysqli_query($link, $query3);
		
		$row = mysqli_fetch_assoc($resultat);
		
		$contador = $row['contador'];
		$i = 0;
		
		while ($i < $contador)
		{
			$query4 = "select ta.id as id from categories as ca inner join tasques as ta ON ta.id_categoria = ca.id where ca.id_taulells = '$idtaula' and ta.asignat = '$idx' limit 1";
			
			$resultat = mysqli_query($link, $query4);

			$row = mysqli_fetch_assoc($resultat);

			$idtasca = $row['id'];
			
			$query5 = "update tasques set asignat = null where id = '$idtasca'";
			
			$row = mysqli_query($link, $query5);
			
			$i = $i +1;
		}
		
		$query6 = "delete from rols_usuaris_taulells where id_taulell = '$idtaula' and mail = '$idx'";
		
		$row = mysqli_query($link, $query6);
		
	mysqli_close();

?>