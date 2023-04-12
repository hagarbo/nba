<?php
	require("config.php");
	
	isset($_GET['season']) ? $season = $_GET['season'] : $season = '07/08';

	$conn = new mysqli(DB_HOST,DB_HOST_USERNAME,DB_HOST_PASSWORD,DB_DATABASE);

	//OBTENER TEMPORADAS
	$query= "SELECT DISTINCT temporada FROM partidos";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	$resultSet = $stmt->get_result();
	$temporadas = $resultSet->fetch_all(MYSQLI_ASSOC);

	//LLAMAR AL PROCEDURE QUE DEVUELVE LA CLASIFICACION
	$query= "CALL clasificacion(?)";
	$stmt = $conn->prepare($query);
	$stmt->bind_param('s',$season);
	$stmt->execute();
	$resultSet = $stmt->get_result();
	$standings = $resultSet->fetch_all(MYSQLI_ASSOC);

	$westHtml = $eastHtml = "<tr>
		      					<th></th>
		      					<th colspan='2' style='text-align:center;'>Team</th>
		      					<th>Played</th>
		      					<th>Wins</th>
		        				<th>Loses</th>
		      				</tr>";
	$countEast = $countWest = 0;
  	foreach ($standings as $key => $value) {
  		if ($value['conferencia'] == 'West'){
  			$countWest++;
  			$westHtml .= "<tr>
  							<td>".$countWest."</td>
  							<td class='clickable' onclick=window.location=('http://nba.local/team.php?team=" . $value['equipo'] ."')><img src='img/".$value['equipo'].".gif'></td>
  							<td class='clickable' onclick=window.location=('http://nba.local/team.php?team=" . $value['equipo'] ."')>".$value['equipo']."</td>
  							<td>".$value['victorias']+$value['derrotas']."</td>
  							<td>".$value['victorias']."</td>
  							<td>".$value['derrotas']."</td>
  						</tr>";
  		}
  		else {
  			$countEast++;
  			$eastHtml .= "<tr>
  							<td>".$countEast."</td>
  							<td class='clickable' onclick=window.location=('http://nba.local/team.php?team=" . $value['equipo'] ."')><img src='img/".$value['equipo'].".gif'></td>
  							<td class='clickable' onclick=window.location=('http://nba.local/team.php?team=" . $value['equipo'] ."')>".$value['equipo']."</td>
  							<td>".$value['victorias']+$value['derrotas']."</td>
  							<td>".$value['victorias']."</td>
  							<td>".$value['derrotas']."</td>
  						</tr>";
  		}
  	}
  	$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>NBApedia</title>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Abril+Fatface|Poppins">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/standings.css">
	<script src="scripts/js/nba.js"></script>
</head>
<body>

<?php require('parts/header.php');?>

<h2>STANDINGS</h2>
<div id="seasons">
		<?php 
			foreach ($temporadas as $key => $value) {
				echo ($value['temporada']==$season) ? "<div class='season-tab active'>".$value['temporada']."</div>" : "<div class='season-tab' onclick=window.location=('http://nba.local/standings.php?season=" . $value['temporada'] ."')>".$value['temporada']."</div>";
			}
		?>
	</div>
</div>

<div class="row">
  <div class="column west-table">
    <table>
    	<thead>
		    	<tr><th colspan="6"><img src="img/west.gif"></th></tr>
		  </thead>
		  <tbody>
		  	<?php echo $westHtml;?>
		  </tbody>
    </table>
  </div>
  <div class="column east-table">
    <table>
	    <thead>
		    	<tr><th colspan="6"><img width="128px" src="img/east.gif"></th></tr>
		  </thead>
		  <tbody>
		  	<?php echo $eastHtml;?>
		  </tbody>
    </table>
  </div>
</div>

</body>
</html>