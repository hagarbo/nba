<?php
	if (isset($_GET['player'])) {
		require('config.php');
		$id = $_GET['player'];
		$conn = new mysqli(DB_HOST,DB_HOST_USERNAME,DB_HOST_PASSWORD,DB_DATABASE);
		$query= "SELECT * FROM jugadores LEFT JOIN estadisticas ON jugadores.codigo=estadisticas.jugador WHERE jugadores.codigo=? ";
		$stmt = $conn->prepare($query);
		$stmt->bind_param('i',$id);
		$stmt->execute();
		$resultSet = $stmt->get_result();
		$stats = $resultSet->fetch_all(MYSQLI_ASSOC);
		$conn->close();
		echo json_encode($stats);
	}
?>