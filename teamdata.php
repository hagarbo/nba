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

		// Stats de la ultima temporada para cada jugador
		$query = "SELECT * FROM estadisticas WHERE jugador=? AND temporada = '07/08'";
		$stmt = $conn->prepare($query);
		$stmt->bind_param('s',$value['codigo']);
		$stmt->execute();
		$resultSet = $stmt->get_result();
		$stats = $resultSet->fetch_assoc();
		
		//Si hay stats de la ultima season
		if ($conn->affected_rows != 0){
			$flipboxbackcontent = "<h2>Last Season</h2>
										<div class='last-season-stats'>
											<div class='last-season-stats-row'>
												<div class='last-season-stats-header'>
													<p>Points</p>
													<p>Assists</p>
												</div>
												<div class='last-season-stats-data'>
													<p>" . $stats['Puntos_por_partido'] . "</p>
													<p>" . $stats['Asistencias_por_partido'] . "</p>
												</div>
											</div>
											<div class='last-season-stats-row'>
												<div class='last-season-stats-header'>
													<p>Rebounds</p>
													<p>Blocks</p>
												</div>
												<div class='last-season-stats-data'>
													<p>" . $stats['Rebotes_por_partido'] . "</p>
													<p>" . $stats['Tapones_por_partido'] . "</p>
												</div>
											</div>
										</div>";
		}
		else $flipboxbackcontent = "<h2>Last Season</h2><h1>NO DATA</h1>";

		//Arranque de fila
		if (($count%$numColumns==0)||($count==0)) 
			$echores = $echores . "<div id='team-row-" . intdiv($count,$numColumns)+1 . "' class='team-row'><!--FILA-->";
		$echores = $echores . "<div id='player-data-" . $value['codigo'] . "' class='flip-box player-data team-" . $_GET['team'] . "' onclick='playerStats(this.id)'>
				<div class='flip-box-inner'>
					<div class='flip-box-front'>
						<img src='img/blank.webp'/>
						<h3>" . $value['Nombre'] ."</h3>
						<div id='datos-basicos'>
							<p>Position:" . $value['Posicion'] . " </p>
							<p>H:" . $value['Altura'] . " </p>
							<p>W:" . $value['Peso'] . " </p>
						</div>
						<h4>" . $value['Procedencia'] . "</h4>
					</div>
					<div class='flip-box-back'>" . $flipboxbackcontent . "
					</div>
				</div>
			</div><!--FICHA-->";
		$count++;
		if ($count%$numColumns==0) $echores = $echores . "</div><!--FILA-->";
	}
	if ($count%$numColumns!=0) $echores = $echores . "</div><!--FILA-->";
	echo $echores;
	$conn->close();

?>



