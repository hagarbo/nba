<?php
	require('../../conf/config.php');
	if (isset($_GET['player']) && isset($_GET['name'])) {
		//Mostramos la página con los datos del equipos
		$player = $_GET['player'];
		$conn = new mysqli(DB_HOST,DB_HOST_USERNAME,DB_HOST_PASSWORD,DB_DATABASE);
		$query= "SELECT * FROM estadisticas WHERE jugador=?";
		$stmt = $conn->prepare($query);
		$stmt->bind_param('s',$player);
		$stmt->execute();
		$resultSet = $stmt->get_result();
		$stats = $resultSet->fetch_all(MYSQLI_ASSOC);

		//CONFIGURAMOS LA SALIDA
		$tabHtml = "<div class='tab'>";
		$divsHtml = "";

		if ($conn->affected_rows == 0) { // Si no hay resultados para el jugador
			$divsHtml = "<div id='tab1' class='tabcontent' style='display:block;'>
							<h2>No hay estadísticas del jugador:</h2>
							<h2>" . $_GET['name'] . "</h2>
						</div>";
		}
		else {
			$count = 0;
			foreach ($stats as $key => $value) {
				$count++;
				if ($count==1) {
					$button_class_string = "'tablinks active'";
					$style = "style='display:block;'";
				}
				else {
					$button_class_string = "'tablinks'";
					$style = "";
				}
				$tabHtml = $tabHtml . "<div class=" . $button_class_string . " onclick=\"openTab(event, 'tab" . $count ."')\">" . $value['temporada'] . "</div>";
				$divsHtml = $divsHtml . "<div id='tab" . $count . "' class='tabcontent' " . $style . ">
										<h3>" . $_GET['name'] . "</h3>
										<p>Puntos por partido: " . $value['Puntos_por_partido'] . "</p>
										<p>Asistencias por partido: " . $value['Asistencias_por_partido'] . "</p>
										<p>Tapones por partido: " . $value['Tapones_por_partido'] . "</p>
										<p>Rebotes por partido: " . $value['Rebotes_por_partido'] . "</p>
										</div>";
			}
		}
		$tabHtml = $tabHtml . "</div><!-- class tab -->";

		echo $tabHtml . $divsHtml;
		$conn->close();
	}

	
?>