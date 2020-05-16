<?php
    $link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');

    if (mysqli_connect_error()) {
        $logMessage = 'MySQL Error: ' . mysqli_connect_error();

        echo $logMessage;
    }

    $id = $_POST['id_tasca'];
    $data = $_POST['data_nova'];


	$query = "UPDATE tasques SET data_limit = '$data' WHERE id = '$id'";

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