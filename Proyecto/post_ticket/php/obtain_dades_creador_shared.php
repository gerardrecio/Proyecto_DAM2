<?php
	$link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');
	
	if (mysqli_connect_error()) {
		$logMessage = 'MySQL Error: ' . mysqli_connect_error();

		echo $logMessage;
	}
	
		$idx = trim($_POST['id_tasca']);

		$query = "select ta.creador from tasques as ta inner join estats as es on ta.estat = es.id inner join categories as ca on ta.id_categoria = ca.id where ta.id = '$idx'";

		$res = mysqli_query($link, $query);
		
		$row = mysqli_fetch_assoc($res);

		$variable = $row["creador"];

		echo trim($variable);
		
		mysqli_close($link);
?>