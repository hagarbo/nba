<header>
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
			<li><?php echo('/stats.php' == $_SERVER['REQUEST_URI'] ? "<a class='active' href='#'>LEAGUE STATS</a>" : "<a href='#'>LEAGUE STATS</a>");?></li>
			<li><?php echo('/quiz.php' == $_SERVER['REQUEST_URI'] ? "<a class='active' href='#'>QUIZ</a>" : "<a href='#'>QUIZ</a>");?></li>
		</ul>
	</div>
</nav>