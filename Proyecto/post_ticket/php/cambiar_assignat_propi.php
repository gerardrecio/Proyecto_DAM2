<?php
	$link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');
	
	if (mysqli_connect_error()) {
		$logMessage = 'MySQL Error: ' . mysqli_connect_error();

		echo $logMessage;
	}
	
		$idx = $_POST['id_tasca'];
		$idx2 = trim($_POST['assignat']);
		
		$query = "update tasques set asignat = '$idx2' where id = '$idx'";

		mysqli_query($link, $query);

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