<?php
	$link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');
	
	if (mysqli_connect_error()) {
		$logMessage = 'MySQL Error: ' . mysqli_connect_error();

		echo $logMessage;
	}
	
		$idx = trim($_POST['correo']);

		$query = "select if(est.descripcio='En proc&eacute;s','En procés',est.descripcio) as descripcio, count(*) as contador from estats as est inner join tasques as ta on ta.estat = est.id group by est.descripcio, ta.asignat  having ta.asignat = '$idx'";

		$res = mysqli_query($link, $query);

		//echo $query;

		$myArr = array();   //array on tindrem tots els retorns en JSON

		while ( $row = mysqli_fetch_assoc($res) )
		{
			array_push($myArr, array('descripcio' => $row['descripcio'],'contador' => $row['contador']));
		}

		echo json_encode($myArr);

	mysqli_close();

?>