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
	<title>NBA Stats</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Abril+Fatface|Poppins">
	<script src="scripts/js/nba.js"></script>
	<script src="https://kit.fontawesome.com/616a10072c.js" crossorigin="anonymous"></script>
</head>
<body onload="loadSelectors()">
	<?php require('parts/header.php'); ?>

	<div id="selectors">
		<label for="selector-team">Pick a Team:</label>
		<select id="selector-team" name="selector-team" onchange="showPlayers(this.value)">
			<option value="empty" selected></option>
			<?php foreach ($teams as $key => $value) {
				echo ($value['Nombre']!=$_GET['team']) ? "<option value='" . $value['Nombre'] . "'>" . $value['Nombre'] . "</option>" : "<option value='" . $value['Nombre'] . "' selected>" . $value['Nombre'] . "</option>";
			}?>
		</select>
		<label for="selector-player">Pick a Player:</label>
		<select id="selector-player" name="selector-player" onchange="showPlayerData(this.value)">
		</select>
	</div>
	<div id="player-info" class="stats">
		
	</div>
</body>
</html>

<?php $conn->close(); ?>