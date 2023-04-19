
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
					const opcion = crearNodo("option",{value:"empty"});
					opcion.innerHTML = "";
					document.getElementById("selector-player").appendChild(opcion);

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
		document.getElementById("identificador").innerHTML = player;
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				const stats = JSON.parse(this.responseText);
				document.getElementById("player-info").style = "background-color: #ccc";
				//FOTO Y NOMBRE EN UN DIV
				const fotoName = crearNodo("div",{id:"foto-name"});
				const foto = crearNodo("img",{src:"https://cdn.nba.com/headshots/nba/latest/260x190/"+stats[0].nba_id+".png",
										onerror:"imgError(this)"});
				fotoName.appendChild(foto);
				const nombre = crearNodo("h3",{id:"Nombre",onclick:"editarCelda(this)"});
				nombre.innerHTML = stats[0].Nombre;
				fotoName.appendChild(nombre);

				//POSICION ALTURA PESO Y PROCEDENCIA EN OTRO DIV
				const datosBasicos = crearNodo("div",{id:"data-player"});
				const posicion = document.createElement("div");
				posicion.innerHTML = "<span>Position</span><p id='Posicion' onclick='editarCelda(this)'>"+fullNamePosition(stats[0].Posicion)+"</p>";
				const altura = document.createElement("div");
				altura.innerHTML = "<span>Height</span><p id='Altura' onclick='editarCelda(this)'>"+stats[0].Altura+"<sup>''</sup></p>";
				const peso = document.createElement("div");
				peso.innerHTML = "<span>Weight</span><p id='Peso' onclick='editarCelda(this)'>"+stats[0].Peso+"<sub>lb</sub></p>";
				const procedencia = document.createElement("div");
				procedencia.innerHTML = "<span>Origin</span><p id='Procedencia' onclick='editarCelda(this)'>"+stats[0].Procedencia+"</p>";
				datosBasicos.appendChild(posicion);
				datosBasicos.appendChild(altura);
				datosBasicos.appendChild(peso);
				datosBasicos.appendChild(procedencia);

				document.getElementById("player-info").appendChild(fotoName);
				document.getElementById("player-info").appendChild(datosBasicos);
			}
		};
		xmlhttp.open("GET","get-player-info.php?player="+player,true);
		xmlhttp.send();
	}
}

function fullNamePosition(pos){
	switch(pos){
	case 'PG':
		return "Point Guard";
	case 'G':
		return "Guard";
	case 'C':
		return "Center";
	case 'F':
		return "Forward";
	default:
		return pos;
	}
}

function crearNodo(tag,atributos){
	nodo = document.createElement(tag);
	for (key in atributos){
		attr = document.createAttribute(key);
		attr.value = atributos[key];
		nodo.setAttributeNode(attr);
	}
	return nodo;
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
	select1.childNodes[0].selected = true;
	for (i = 1; i < select2.childNodes.length; i++){
		select2.childNodes[i].remove();
	}
}

function editarCelda(celda){
	var dialog = document.getElementById('edit-dialog');
	dialog.showModal();
	dialog.addEventListener('close',() => dialogHandler(dialog,celda))
}

function dialogHandler(dialog,celda){
	var input = document.getElementById('update-data-input');
	if (dialog.returnValue=="confirm") {
		//TO DO Validar el input
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				celda.innerHTML = document.getElementById('update-data-input').value;
			}
			else alert('No se han podido realizar los cambios');
		};
		xmlhttp.open("GET","update-player.php?id="+document.getElementById('identificador').innerHTML+"&"+celda.id+"="+input.value,true);
		xmlhttp.send();

	}
	input.value = "";
}