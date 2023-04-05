<?php
	require("config.php");
	if (isset($_GET['team'])) {
		//Mostramos la página con los datos del equipos
		$equipo = $_GET['team'];
		$conn = new mysqli(DB_HOST,DB_HOST_USERNAME,DB_HOST_PASSWORD,DB_DATABASE);
		$query= "SELECT * FROM jugadores WHERE Nombre_equipo=?";
		$stmt = $conn->prepare($query);
		$stmt->bind_param('s',$equipo);
		$stmt->execute();
		$resultSet = $stmt->get_result();
		$players = $resultSet->fetch_all(MYSQLI_ASSOC);
	}

	$count = 0;
	$numColumns = 4; //COLUMNAS O FICHAS POR FILA
	$echores = "";
	foreach ($players as $key => $value) {
		if (($count%$numColumns==0)||($count==0)) 
			$echores = $echores . "<div id='team-row-" . intdiv($count,$numColumns)+1 . "' class='team-row'><!--FILA-->";
		$echores = $echores . "<div id='player-data-" . $value['codigo'] . "' class='player-data " . $_GET['team'] . "' onclick='playerStats(this.id)'>
				<img src='img/blank.webp'/>
				<h3>" . $value['Nombre'] ."</h3>
				<div id='datos-basicos'>
					<p>Position: <strong>" . $value['Posicion'] . "</strong></p>
					<p>H: <strong>" . $value['Altura'] . "</strong></p>
					<p>W: <strong>" . $value['Peso'] . "</strong></p>
				</div>
				<h4>" . $value['Procedencia'] . "</h4>
			</div><!--FICHA-->";
		$count++;
		if ($count%$numColumns==0) $echores = $echores . "</div><!--FILA-->";
	}
	if ($count%$numColumns!=0) $echores = $echores . "</div><!--FILA-->";
	echo $echores;
	$conn->close();

?>



