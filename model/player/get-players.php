<?php
	if (isset($_GET['team'])) {
		require('../../conf/config.php');
		$equipo = $_GET['team'];
		$conn = new mysqli(DB_HOST,DB_HOST_USERNAME,DB_HOST_PASSWORD,DB_DATABASE);
		$query= "SELECT codigo,Nombre FROM jugadores WHERE Nombre_equipo=?";
		$stmt = $conn->prepare($query);
		$stmt->bind_param('s',$equipo);
		$stmt->execute();
		$resultSet = $stmt->get_result();
		$players = $resultSet->fetch_all(MYSQLI_ASSOC);
		$conn->close();
		echo json_encode($players);
	}
?>