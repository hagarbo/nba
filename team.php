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
	<script src="js/nba.js"></script>
</head>
<body>
	<?php require('parts/header.php'); ?>
	<form action="">
		<div id="team-selector">
			<label for="selector">Pick a Team:</label>
			<select name="selector" onchange="refresh(this.value)">
				<?php foreach ($teams as $key => $value) {
					echo ($value['Nombre']!=$_GET['team']) ? "<option value='" . $value['Nombre'] . "'>" . $value['Nombre'] . "</option>" : "<option value='" . $value['Nombre'] . "' selected>" . $value['Nombre'] . "</option>";
				}?>
			</select>
		</div>
		<div id="player-stats" class="stats">
			
		</div>
		<div id="team-frame">
			<?php 
				if (isset($_GET['team']))
					echo "<script>refresh('" . $_GET['team'] . "');</script>";
			?>
		</div>
	</form>

</body>
</html>

<?php $conn->close(); ?>
