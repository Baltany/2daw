<?php
// Nos conectamos a la bbdd
function getConexion(){
    $host = "localhost";
    $user = "dwes";
    $password = "abc123.";
    $dbname = "jugadores";
    try{
        $connection = new mysqli($host, $user, $password, $dbname);
    }catch (Exception $ex){
        echo $ex->getMessage();
    
    }    
    return $connection;
}

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

// Mostrar Jugador
function getJugador(){
    $connection = getConexion();
    $stmt = $connection -> prepare("SELECT * FROM jugadores");
    $stmt->execute();
    if($stmt === false){
        die("Error al obtener los datos de la bbdd". $connection -> error);
    }

    $result = $stmt->get_result();
    $jugadores = [];
    while($jugador = $result -> fetch_object()){
        $jugadores[] = $jugador;

    }

    $stmt->close();
    return $jugadores;
}

// Editar jugador
function editJugador($id,$nombre,$dni,$dorsal,$posicion,$equipo,$goles){
    $connection = getConexion();
    $stmt = $connection -> prepare("UPDATE jugadores SET nombre = ?,dni = ?,dorsal = ?,posicion = ?, equipo = ?,goles = ? WHERE id = ?");

    if($stmt === false){
        die("Error al obtener los datos de la bbdd". $connection -> error );
    }
    $stmt -> bind_param("ssssssi",$nombre,$dni,$dorsal,$posicion,$equipo,$goles,$id);

    if($stmt->execute()){
        echo "Filas afectadas: " . $stmt->affected_rows;
    }else{
        echo "No se ha modficido ninguna fila";
    }

}

// Buscar jugador
function buscarJugador($nombre){
    $connection = getConexion();
    $stmt = $connection -> prepare("SELECT * FROM jugadores where nombre LIKE ?");
    //$html = "<table>";
    if($stmt === false){
        die("Error al obtener los datos de la bbdd".$connection -> error);
    }

    $nombre = "%" . $nombre . "%";
    $stmt -> bind_param("s",$nombre);
    if($stmt-> execute()){
        $result = $stmt->get_result();
        $jugadores = [];
        while($jugador = $result -> fetch_object()){
            $jugadores[] = $jugador;
        }
        print_r($jugadores);
        //$html += "</table>";
    }else{
        echo "No se ha modificado ninguna fila";
    }

    return $jugadores;

}



?>