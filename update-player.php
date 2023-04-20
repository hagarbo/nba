<?php
	function validar($str){
		return true;
	}

	header("Content-Type: application/json; charset=UTF-8");
	$obj = json_decode($_POST["x"], false);
	$valido = validar($obj->valor);
	
	if ($valido) {
		require('config.php');
		$conn = new mysqli(DB_HOST,DB_HOST_USERNAME,DB_HOST_PASSWORD,DB_DATABASE);
		$query= "SELECT codigo FROM jugadores WHERE codigo=?";
		$stmt = $conn->prepare($query);
		$stmt->bind_param('i',$obj->id);
		$stmt->execute();
		$resultSet = $stmt->get_result();
		if ($resultSet->num_rows != 0){
			$query = "UPDATE jugadores SET ".$obj->campo." = ? WHERE codigo = ?";
			$stmt = $conn->prepare($query);
			$stmt->bind_param('ss',$obj->valor,$obj->id);
			$stmt->execute();
		}

		$conn->close();

	}

?>