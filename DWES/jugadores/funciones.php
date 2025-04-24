<?php
// Insert into jugadores values("lamine","12345678x","19","DELANTERO","FCBARCELONA","5");
function addJugador($nombre,$dni,$dorsal,$posicion,$equipo,$goles){
    $connection = getConexion();   
    $stmt = $connection -> prepare("INSERT INTO jugadores(nombre, dni, dorsal, posicion, equipo, goles) VALUES(?,?,?,?,?,?)");
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

// Recorremos el enum 'Posiciones' para así poder mostrarlo al cliente
function getPosiciones(){
    $connection=getConexion();
    try{
        $result = $connection->query("SELECT DISTINCT posicion FROM posiciones");
    }catch(Exception $ex){
        echo $ex->getMessage();
    }
    
        return $result;
}



function getConexion(){
    $host = "localhost";
    $user = "dwes";
    $password = "abc123.";
    $dbname = "jugadores";

    $connection = new mysqli($host, $user, $password, $dbname);
    
    if ($connection->connect_error) {
        die("Conexión fallida: " . $connection->connect_error);
    }
    return $connection;
}


?>