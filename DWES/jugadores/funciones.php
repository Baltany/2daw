<?php
// recogemos el objeto conexion
require_once "conexion.php";

// Insert into jugadores values(1,"lamine","12345678x","19","DELANTERO","FCBARCELONA","5");
function addJugador($nombre,$dni,$dorsal,$posicion,$equipo,$goles){
    global $connection;

    $stmt = $connection -> prepare("INSER INTO jugadores(id,nombre, dni, dorsal, posicion, equipo, goles) VALUES(?.?,?,?,?,?,?)");
    if($stmt === false){
        die("Error en la preparacion ". $connection->error);
    }
    // En este caso como estoy usando todo en la base de datos como string usamos 's' si usara algun entero sería 'i'
    $stmt -> bind_param("ssssss",$id,$nombre,$dni,$dorsal,$posicion,$equipo,$goles);
}

?>