<?php
	$link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');
	
	if (mysqli_connect_error()) {
		$logMessage = 'MySQL Error: ' . mysqli_connect_error();

		echo $logMessage;
	}
	
		$idx = trim($_POST['id_tasca']);

		$query = "select creador from taulells where id = 20 and id = (select id_taulells from categories where id = (select id_categoria from tasques where id = '$idx'))";

		$res = mysqli_query($link, $query);
		
		$row = mysqli_fetch_assoc($res);

		$variable = $row["creador"];

		echo trim($variable);
		
		mysqli_close($link);
?>