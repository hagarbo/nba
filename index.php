<?php
	require("config.php");

	$conn = new mysqli(DB_HOST,DB_HOST_USERNAME,DB_HOST_PASSWORD,DB_DATABASE);
	$query= "SELECT Nombre FROM equipos";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	$resultSet = $stmt->get_result();
	$teams = $resultSet->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>NBApedia</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="js/nba.js"></script>
</head>
<body>
	<form action="">
		<div id="team-selector">
			<label for="selector">Equipo:</label>
			<select name="selector" onchange="refresh(this.value)">
				<option value="empty">Seleccione el equipo</option>
				<?php foreach ($teams as $key => $value) {
					echo "<option value='" . $value['Nombre'] . "'>" . $value['Nombre'] . "</option>";
				}?>
			</select>
		</div>
		<hr>
		<div id="player-stats" class="stats">
			
		</div>
		<div id="team-frame">
			
		</div>
	</form>

</body>
</html>
