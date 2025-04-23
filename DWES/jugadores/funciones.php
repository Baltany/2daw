<?php
// recogemos el objeto conexion
require_once "conexion.php";

// Insert into jugadores values(1,"lamine","12345678x","19","DELANTERO","FCBARCELONA","5");
function addJugador($nombre,$dni,$dorsal,$posicion,$equipo,$goles){
    global $connection;
    
    $stmt = $connection -> prepare("INSER INTO jugadores(nombre, dni, dorsal, posicion, equipo, goles) VALUES(?.?,?,?,?,?,?)");
    if($stmt === false){
        die("Error en la preparacion ". $connection->error);
    }
    // En este caso como estoy usando todo en la base de datos como string usamos 's' si usara algun entero sería 'i'
    $stmt -> bind_param("ssssss",$nombre,$dni,$dorsal,$posicion,$equipo,$goles);
    
    // Comprobamos que se ha ejecutado correctamente
    if($stmt-> execute()){
        echo "Jugador insertado correctamente,Filas afectadas: " . $stmt->affected_rows;
    }else{
        echo "Error de insercion ". $stmt->error;
    }
    
    // Una vez terminamos la sentencia y ejecutada cerramos la conexion
    $stmt->close();
}

function getPosicion(){
    global $connection;
    $result = $connection->query("SELECT DISTINCT posicion FROM jugadores");
    $posiciones = [];

    if($result && $result -> num_rows > 0){
        while($row = $result -> fetch_object()){
            $clave = explode(',',$row -> clave);
            foreach($clave as $valor){
                $valor = trim($valor);
                if(!in_array($valor,$posiciones)){
                    $posiciones[] = $valor;
                }
            }
        }
    }


}

?>