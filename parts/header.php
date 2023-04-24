<header>
	<?php 
		if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
			$logged = true;
  			echo "<p>Welcome, ".$_SESSION['username']."  <a href='logout.php'>Log Out</a></p>";
		}
  		else {
  			$logged = false;
  			echo "<p><a href='login.php'>Log In</a></p>";
  		}
  	?>
	<div id="header-logo">
		<img src="img/nba.png">
		<h1> NBA Stats </h1>
		<img src="img/nba.png">
	</div>
</header>
<nav>
	<div id="nav_menu" class="nav_bar">
		<ul>
			<li><?php echo('/index.php' == $_SERVER['REQUEST_URI'] ? "<a class='active' href='#'>HOME</a>" : "<a href='index.php'>HOME</a>");?></li>
			<li><?php echo('/team.php' == $_SERVER['REQUEST_URI'] ? "<a class='active' href='#'>TEAMS</a>" : "<a href='team.php'>TEAMS</a>");?></li>
			<li><?php echo('/standings.php' == $_SERVER['REQUEST_URI'] ? "<a class='active' href='#'>STANDINGS</a>" : "<a href='standings.php'>STANDINGS</a>");?></li>
			<?php
			if ($logged){
				echo('/player-selection.php' == $_SERVER['REQUEST_URI'] ? "<li><a class='active' href='#'>PLAYERS</a></li>" : "<li><a href='/player-selection.php'>PLAYERS</a></li>");
			}
			?>
		</ul>
	</div>
</nav>