<?php
// Array multidimensional de equipos de la NBA por conferencia y división
$nba_teams = array(
    "Este" => array(
        "Atlántico" => array("Boston Celtics", "Brooklyn Nets", "New York Knicks", "Philadelphia 76ers", "Toronto Raptors"),
        "Central" => array("Chicago Bulls", "Cleveland Cavaliers", "Detroit Pistons", "Indiana Pacers", "Milwaukee Bucks"),
        "Sureste" => array("Atlanta Hawks", "Charlotte Hornets", "Miami Heat", "Orlando Magic", "Washington Wizards")
    ),
    "Oeste" => array(
        "Noroeste" => array("Denver Nuggets", "Minnesota Timberwolves", "Oklahoma City Thunder", "Portland Trail Blazers", "Utah Jazz"),
        "Pacífico" => array("Golden State Warriors", "Los Angeles Clippers", "Los Angeles Lakers", "Phoenix Suns", "Sacramento Kings"),
        "Suroeste" => array("Dallas Mavericks", "Houston Rockets", "Memphis Grizzlies", "New Orleans Pelicans", "San Antonio Spurs")
    )
);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Equipos de la NBA</title>
	<style>
		.container {
			display: flex;
			flex-wrap: wrap;
			justify-content: center;
			align-items: center;
			gap: 20px;
			margin-top: 20px;
		}
		.team-card {
			background-color: #eee;
			padding: 10px;
			width: 200px;
			text-align: center;
			border-radius: 5px;
			box-shadow: 0px 0px 5px 1px rgba(0,0,0,0.2);
		}
		.team-logo {
			height: 150px;
			width: 150px;
			margin-bottom: 10px;
		}
		.team-name {
			font-weight: bold;
			font-size: 18px;
		}
	</style>
</head>
<body>
	<h1>Equipos de la NBA</h1>

	<?php
	// Loop a través del array multidimensional y muestra los equipos en tarjetas
	foreach ($nba_teams as $conference => $divisions) {
	    echo "<h2>$conference</h2>";
	    echo "<div class='container'>";
	    foreach ($divisions as $division => $teams) {
	        echo "<h3>$division</h3>";
	        foreach ($teams as $team) {
	            echo "<div class='team-card'>";
	            echo "<img class='team-logo' src='https://www.nba.com/assets/logos/teams/primary/web/$team.svg'>";
	            echo "<div class='team-name'>$team</div>";
	            echo "</div>";
	        }
	    }
	    echo "</div>";
	}
	?>

</body>
</html>
