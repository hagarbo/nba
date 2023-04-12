<?php
	require("config.php");

	$conn = new mysqli(DB_HOST,DB_HOST_USERNAME,DB_HOST_PASSWORD,DB_DATABASE);
	$query= "SELECT * FROM equipos ORDER BY conferencia DESC";
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
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Abril+Fatface|Poppins">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="scripts/js/nba.js"></script>
</head>
<body>

<?php
	require('parts/header.php');
	$westDiv ="";
	$eastDiv ="";
	foreach ($teams as $key => $value) {
		if ($value['Conferencia'] == "West"){
		    $westDiv = $westDiv . "<div class='team-card' onclick=window.location=('http://nba.local/team.php?team=" . $value['Nombre'] ."')>
		    				<img class='team-logo' src='img/" . $value['Logo'] ."'>"
		    				/*<div class='team-name'>" . $value['Ciudad'] . " " . $value['Nombre'] . "</div>*/
		    			. "</div>";
		}
		else {
			$eastDiv = $eastDiv . "<div class='team-card' onclick=window.location=('http://nba.local/team.php?team=" . $value['Nombre'] ."')>
		    				<img class='team-logo' src='img/" . $value['Logo'] . "'>"
		    				/*<div class='team-name'>" . $value['Ciudad'] . " " . $value['Nombre'] . "</div>*/
		    			. "</div>";
		}
	}
	echo "<div id='team-header'>
			
			
		</header>";
	echo "<div id='all-teams'>";
	echo "<div class='container west'>
			<div id='west-header'>
				<img src='img/west.gif'>
			</div>";
	echo $westDiv;
	echo "</div>";
	echo "<div class='container east'>
			<div id='east-header'>
				<img src='img/east.gif'>
			</div>";
	echo $eastDiv;
	echo "</div>";
	echo "</div>";
?>

</body>
</html>
<?php $conn->close(); ?>