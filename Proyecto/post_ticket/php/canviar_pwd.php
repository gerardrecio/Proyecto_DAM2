<?php
	$link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');
	
	if (mysqli_connect_error()) {
		$logMessage = 'MySQL Error: ' . mysqli_connect_error();

		echo $logMessage;
	}
	
		$password = $_POST['pwd'];
		$idx2 = trim($_POST['email']);

		$pwdcrypt = password_hash($password, PASSWORD_BCRYPT);


		$query = "UPDATE usuaris SET pwd = '$pwdcrypt' WHERE mail = '$idx2'";

		$row = mysqli_query($link, $query);

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