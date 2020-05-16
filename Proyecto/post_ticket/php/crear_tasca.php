<?php
	$link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');
	
	if (mysqli_connect_error()) {
		$logMessage = 'MySQL Error: ' . mysqli_connect_error();

		echo $logMessage;
	}
	
		$idx = trim($_POST['nom']);
		$idx2 = $_POST['data_limit'];
		$idx3 = $_POST['assignat'];
		$idx4 = $_POST['categoria'];
		$idx5 = trim($_POST['missatge']);
		$idx6 = $_POST['creador'];
		$idx7 = $_POST['nom_taulell'];
		$idx8 = $_POST['creador_tasca'];

		$query = "select id from categories where id_taulells = (select id from taulells where nom = '$idx7' and creador = '$idx6') and nom = '$idx4' limit 1";
			
		$resultat = mysqli_query($link, $query);

		$row = mysqli_fetch_assoc($resultat);

		$idcategoria = $row['id'];
		

		
		$query2 = "insert into tasques (titol, cos_missatge, id_categoria, estat, asignat, data_limit, creador) values ('$idx', '$idx5','$idcategoria','1','$idx3','$idx2','$idx8')";
		
		$row = mysqli_query($link, $query2);
	
		if ($row == true)
		{
			echo 1;
		}
		else
		{
			echo 0;
		}

	mysqli_close();

?>