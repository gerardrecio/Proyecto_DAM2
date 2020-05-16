<?php
	$link = mysqli_connect('217.76.150.88', 'qadf185', '1234Asdf', 'qadf185');
	
	if (mysqli_connect_error()) {
		$logMessage = 'MySQL Error: ' . mysqli_connect_error();

		echo $logMessage;
	}
	
		$idx = $_POST['id_taulell'];
		$idx2 = trim($_POST['creador']);
		$categories = $_POST['categories'];
		$usuaris = $_POST['usuaris'];
		$order = $_POST['order'];
		$contadorusu = sizeof($usuaris);
		$contadorcat = sizeof($categories);

		$query = "select ta.id,ta.titol,ca.nom as categoria,ta.asignat,DATE_FORMAT(ta.data_limit, '%d-%m-%Y') as data_limit,est.descripcio as estat,ta.estat as color from tasques as ta inner join categories as ca on ta.id_categoria = ca.id inner join taulells as t on ca.id_taulells = t.id inner join estats as est on ta.estat = est.id where t.nom = '$idx' and t.creador = '$idx2' and ta.estat <> 3";
		if ($contadorusu > 0) {
			$query .= " and (";
			for($i = 0; $i < $contadorusu;$i++){
				if($i>0) {
					$query .= " Or ";
				}
				$query .= " asignat = '" . $usuaris[$i] . "'";
			}
			$query .= ")";
		}
		if ($contadorcat > 0) {
			$query .= " and (";
			for($i = 0; $i < $contadorcat;$i++){
				if($i>0) {
					$query .= " Or ";
				}
				
				$querycat = "select id from categories where id_taulells = (select id from taulells where creador = '$idx2' and nom = '$idx') and nom = '$categories[$i]'";
				$res = mysqli_query($link, $querycat);
				$row = mysqli_fetch_assoc($res);
				
				$query .= " ta.id_categoria = " . $row['id'];
				
			}
			$query .= ")";
		}
		
		if($order == "0"){
			$query .= " order by data_limit asc";
		}
		else{
			$query .= " order by data_limit desc";
		}		
		
		
		$res = mysqli_query($link, $query);

		//echo $query;

		$myArr = array();   //array on tindrem tots els retorns en JSON

		while ( $row = mysqli_fetch_assoc($res) )
		{
			array_push($myArr, array('titol' => $row['titol'],'categoria' => $row['categoria'],'asignat' => $row['asignat'],'data_limit' => $row['data_limit'],'estat' => $row['estat'],'id' => $row['id'],'color' => $row['color']));
		}

		echo json_encode($myArr);



	mysqli_close();

?>