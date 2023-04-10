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
</head>
<body>

<?php require('parts/header.php');?>
<style type="text/css">
* {
  box-sizing: border-box;
}

.row {
  display: flex;
  flex-wrap: wrap;
  margin-left:-5px;
  margin-right:-5px;
}

.column {
  flex: 50%;
}

h2{
	background-color: dodgerblue;
	color: white;
	margin: 0;
	padding: 10px;
	border-top : 1px solid white;
	border-bottom : 1px solid white;
}

table {
	margin: auto;
	border-collapse: collapse;
	border-spacing: 0;
	max-width: 800px;
	border: 1px solid #ddd;
}
.clickable{
	cursor: pointer;
}
.img-header{
	width: 100%;
	display: flex;
	justify-content: center;
	margin: 10px;
}
.img-header img {
	border-radius: 100px;
	width: 128px;
	margin: auto;
}

th,td {
  text-align: left;
  padding: 16px;
}

td img{
	width: 64px;
	filter: brightness(1.1);
 	mix-blend-mode: multiply;
}
tr:nth-child(odd) {
	background-color: #ccc;
}
tr:nth-child(even) {
  background-color: #f2f2f2;
}
#seasons {
	overflow: hidden;
  	border: 1px solid #ccc;
  	background-color: #f1f1f1;
}
#seasons .season-tab{
	background-color: inherit;
  	float: left;
  	border: none;
  	outline: none;
  	cursor: pointer;
  	padding: 14px 16px;
  	transition: 0.3s;
}
#seasons .season-tab:hover{
	background-color: #ddd;
}
#seasons .season-tab:active{
	background-color: #ccc;
}

</style>
</head>
<body>

<h2>STANDINGS</h2>
<div id="seasons">
		<?php 
			foreach ($temporadas as $key => $value) {
				echo ($value['temporada']==$season) ? "<div class='season-tab active'>".$value['temporada']."</div>" : "<div class='season-tab'>".$value['temporada']."</div>";
			}
		?>
	</div>
</div>

<div class="row">
  <div class="column">
  	<div class="img-header"><img src="img/west.gif"></div>
    <table>
		<?php echo $westHtml;?>
    </table>
  </div>
  <div class="column">
  	<div class="img-header"><img src="img/east.gif"></div>
    <table>
	    <?php echo $eastHtml;?>
    </table>
  </div>
</div>

</body>
</html>