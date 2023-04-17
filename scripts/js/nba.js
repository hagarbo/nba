
function refresh(equipo){
	if (equipo == 'empty'){
		document.getElementById("team-frame").innerHTML = 
			"<span style='color:white;font-size:40px;font-weight:600;text-align:center;'>No has seleccionado ningún equipo</span>";
	}
	else {
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("team-frame").innerHTML = this.responseText;
			}
		};
		xmlhttp.open("GET","teamdata.php?team="+equipo,true);
		xmlhttp.send();
	}
}

function playerStats(elementId){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("player-stats").innerHTML = this.responseText;
		}
	};
	playerId=elementId.replace("player-data-","");
	playerName=document.getElementById(elementId).getElementsByTagName('h3')[0].innerHTML;
	xmlhttp.open("GET","playerstats.php?player="+playerId+"&name="+playerName,true);
	xmlhttp.send();
}

function openTab(evt, tabName) {
	var i, tabcontent, tablinks;
	debugger;
	tabcontent = document.getElementsByClassName("tabcontent");
	for (i = 0; i < tabcontent.length; i++) {
		tabcontent[i].style.display = "none";
	}
	tablinks = document.getElementsByClassName("tablinks");
	for (i = 0; i < tablinks.length; i++) {
		tablinks[i].className = tablinks[i].className.replace(" active", "");
	}
	document.getElementById(tabName).style.display = "block";
	evt.currentTarget.className += " active";
}

// When the user scrolls the page, execute myFunction
window.onscroll = function() {
	stickyStats()
};


// Add the sticky class to the header when you reach its scroll position. 
//Remove "sticky" when you leave the scroll position
function stickyStats() {
	if (document.getElementById("nav_menu").innerHTML!=""){
		// Get the header
		var header = document.getElementById("nav_menu");
		// Get the offset position of the navbar
		var sticky = header.offsetTop;
		if (window.pageYOffset > sticky) {
			header.classList.add("sticky");
		} else {
		    header.classList.remove("sticky");
		}
	}
	if (document.getElementById("player-stats").innerHTML!=""){
		// Get the stats div
		var stats = document.getElementById("player-stats");
		// Get the offset position of the box
		var sticky = stats.offsetTop;
		if (window.pageYOffset > sticky) {
			stats.classList.add("sticky");
		} else {
		    stats.classList.remove("sticky");
		}
	}
} 

function onPlayerHover(elementId) {
	document.getElementById(elementId).firstChild.firstChild.classList.add( "fa-beat-fade");
	document.getElementById(elementId).childNodes[1].classList.add( "showlist");
}

function onPlayerOut(elementId) {
	document.getElementById(elementId).firstChild.firstChild.classList.remove( "fa-beat-fade");
	document.getElementById(elementId).childNodes[1].classList.remove( "showlist");
}

function onPlayerClick(elementId) {
	for (i = 0; i < document.getElementById(elementId).parentNode.childElementCount; i++){
		document.getElementById(elementId).parentNode.childNodes[i].style.display = "none";
	}
	document.getElementById(elementId).style.display = "block";
	document.getElementById(elementId).parentNode.parentNode.firstChild.firstChild.classList.remove( "fa-beat-fade");
	document.getElementById(elementId).parentNode.classList.remove( "showlist");
}

function showPlayers(equipo){
	if (equipo == 'empty'){
		document.getElementById("player-info").innerHTML = 
			"<span style='color:white;font-size:40px;font-weight:600;text-align:center;'>No has seleccionado ningún equipo</span>";
	}
	else {
		document.getElementById("player-info").innerHTML = "";
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				const players = JSON.parse(this.responseText);
				for (let x in players) {
					const opcion = document.createElement("option");
					const value = document.createAttribute("value");
					value.value = players[x].codigo
					opcion.setAttributeNode(value);
					opcion.innerHTML = players[x].Nombre;
					document.getElementById("selector-player").appendChild(opcion);	
				}		
			}
		};
		xmlhttp.open("GET","get-players.php?team="+equipo,true);
		xmlhttp.send();
	}
}

function showPlayerData(player){
	if (player == 'empty'){
		document.getElementById("player-info").innerHTML = 
			"<span style='color:white;font-size:40px;font-weight:600;text-align:center;'>No has seleccionado ningún jugador</span>";
	}
	else {
		document.getElementById("player-info").innerHTML = "";
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				const stats = JSON.parse(this.responseText);
				
				//FOTO Y NOMBRE EN UN DIV
				fotoName = document.createElement("div");
				fotoNameID = document.createAttribute("id");
				fotoNameID.value = "foto-name";
				fotoName.setAttributeNode(fotoNameID);
				foto = document.createElement("img");
				fotosrc = document.createAttribute("src");
				fotosrc.value = "https://cdn.nba.com/headshots/nba/latest/260x190/"+stats[0].nba_id+".png";
				fotoError = document.createAttribute("onerror");
				fotoError.value="imgError(this)";
				foto.setAttributeNode(fotosrc);
				fotoName.appendChild(foto);
				name = document.createElement("h2");
				name.innerHTML = stats[0].Nombre;
				fotoName.appendChild(name);

				//POSICION ALTURA PESO Y PROCEDENCIA EN OTRO DIV
				datosBasicos = document.createElement("div");
				datosBasicosID = document.createAttribute("id");
				datosBasicosID.value = "datos-basicos";
				datosBasicos.setAttributeNode(datosBasicosID);
				altura = document.createElement("p");
				

				document.getElementById("player-info").appendChild(fotoName);

				console.log(stats[0]);
			}
		};
		xmlhttp.open("GET","get-player-info.php?player="+player,true);
		xmlhttp.send();
	}
}

function imgError(img){
	img.src = "img/fallback.png";
}

function loadSelectors(){
	const select1 = document.getElementById("selector-team");
	const select2 = document.getElementById("selector-player");
	for (i = 0; i < select1.childNodes.length; i++){
		select1.childNodes[i].selected = false;
	}
	select1.childNodes[0] = true;
	for (i = 1; i < select2.childNodes.length; i++){
		select2.childNodes[i].remove();
	}
}