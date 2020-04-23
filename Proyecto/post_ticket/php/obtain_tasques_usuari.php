<?php
	$link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');
	
	if (mysqli_connect_error()) {
		$logMessage = 'MySQL Error: ' . mysqli_connect_error();

		echo $logMessage;
	}
	
		$idx = $_POST['tablero'];
		$idx2 = trim($_POST['creador']);

		$query = "select tu.mail as mail,count(ta.titol) as numtasques from taulell_usuaris as tu inner join taulells as t ON t.id = tu.id_taulell inner join categories as ca ON t.id = ca.id_taulells left join tasques as ta ON ca.id = ta.id_categoria and tu.mail = ta.asignat group by tu.mail,t.nom,t.creador having (t.nom = '$idx' and t.creador = '$idx2')";

		$res = mysqli_query($link, $query);

		//echo $query;

		$myArr = array();   //array on tindrem tots els retorns en JSON

		while ( $row = mysqli_fetch_assoc($res) )
		{
			array_push($myArr, array('mail' => $row['mail'],'numtasques' => $row['numtasques']));
		}

		echo json_encode($myArr);

	mysqli_close();

?>