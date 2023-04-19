<?php
	if (isset($_GET['id'])) {
		$opcion = "";
		if (isset($_GET['Nombre'])) $opcion = "Nombre";
		if (isset($_GET['Altura'])) $opcion = "Altura";
		if (isset($_GET['Peso'])) $opcion = "Peso";
		if (isset($_GET['Procedencia'])) $opcion = "Procedencia";
		if (isset($_GET['Posicion'])) $opcion = "Posicion";
		
		if ($opcion != "") {
			require('config.php');
			$id = $_GET['id'];
			$conn = new mysqli(DB_HOST,DB_HOST_USERNAME,DB_HOST_PASSWORD,DB_DATABASE);
			$query= "SELECT codigo FROM jugadores WHERE codigo=?";
			$stmt = $conn->prepare($query);
			$stmt->bind_param('i',$id);
			$stmt->execute();
			$resultSet = $stmt->get_result();
			if ($resultSet->num_rows != 0){
				$query = "UPDATE jugadores SET ".$opcion." = ".$_GET[$opcion];
				echo $query;
				$stmt = $conn->prepare($query);
				$stmt->execute();
			}

			$conn->close();

		}
	}
?>