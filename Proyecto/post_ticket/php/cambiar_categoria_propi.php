<?php
	$link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');
	
	if (mysqli_connect_error()) {
		$logMessage = 'MySQL Error: ' . mysqli_connect_error();

		echo $logMessage;
	}
	
		$idx = $_POST['id_tasca'];
		$idx2 = $_POST['categoria'];

		$query = "select id from categories where id_taulells = (select id_taulells from tasques as ta inner join categories as ca on ta.id_categoria = ca.id where ta.id = '$idx') and nom = '$idx2'";

		$res = mysqli_query($link, $query);

		$tp = mysqli_fetch_assoc($res);
		
		$id_bona = $tp['id'];
		
		$query2 = "update tasques set id_categoria = '$id_bona' where id = '$idx'";

		mysqli_query($link, $query2);

        if (mysqli_affected_rows($link) > 0)
        {
            echo 1;
        }
        else
        {
            echo 0;
        }

	mysqli_close();

?>