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
		xmlhttp.open("GET","model/player/get-players.php?team="+equipo,true);
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
		xmlhttp.open("GET","model/player/get-player-info.php?player="+player,true);
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

function editarCelda(celda){
	var dialog = document.getElementById('edit-dialog');
	var input = document.getElementById('update-data-input');
	input.value = "";
	dialog.showModal();
	dialog.addEventListener('close',() => dialogHandler(dialog,celda));
}

function dialogHandler(dialog,celda){

	var input = document.getElementById('update-data-input');
	if (dialog.returnValue=="confirm") {
		var jugador_id = document.getElementById('identificador').innerHTML;
		const body = JSON.stringify({id: jugador_id, campo: celda.id, valor: input.value});
		const xmlhttp = new XMLHttpRequest();
		
		xmlhttp.onload = function() {
			if (this.status == 200) {
				celda.innerHTML = document.getElementById('update-data-input').value;
				console.log(this.responseText);
			}
			else alert('No se han podido realizar los cambios');
		}
		xmlhttp.open("POST", "model/player/update-player.php");
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttp.send("x=" + body);
	}
}