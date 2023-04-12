# Este script hace uso de la api https://github.com/swar/nba_api para recopilar los ids de los jugadores en 
# la pagina oficial de la nba para poder recuperar información sobre ellos, fotos o estadisticas
import mysql.connector
from nba_api.stats.static import players

db = mysql.connector.connect(
	host="localhost",
	user="nba",
	password="12345",
	database="nba"
	)

cursor = db.cursor()
cursor.execute("SELECT Nombre FROM jugadores")
result = cursor.fetchall()

queryUpdate = "UPDATE jugadores SET nba_id = %s WHERE Nombre = %s"

#UNCOMMENT BEFORE EXECUTION
"""
for i in result:
	name = i[0]
	player = players.find_players_by_full_name(name)
	if player!=[]:
		nbaID = player[0]['id']
		args = (nbaID, name)
		cursor.execute(queryUpdate,args)
		db.commit()
"""

player = players.find_players_by_full_name('Ron Artest III')
print(player)