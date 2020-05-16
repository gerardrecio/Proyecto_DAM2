<?php
	$link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');
	
	if (mysqli_connect_error()) {
		$logMessage = 'MySQL Error: ' . mysqli_connect_error();

		echo $logMessage;
	}
	
		$password = $_POST['pwd'];
		$password_old = $_POST['pwd_old'];
		$idx2 = trim($_POST['email']);

		$queryxd = "SELECT pwd FROM usuaris WHERE mail = '$idx2'";

		$res = mysqli_query($link, $queryxd);

		$row = mysqli_fetch_assoc($res);

		$pwdold_crypted = $row["pwd"];

		if (password_verify($password_old, $pwdold_crypted))
		{
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
		}
		else
		{
			echo 0;
		}
		
	mysqli_close();

?>