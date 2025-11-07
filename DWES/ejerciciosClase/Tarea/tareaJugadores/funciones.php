<?php
function getConnection(){
    $host = "localhost";
    $user = "dwes";
    $password = "abc123.";
    $dbname = "jugadores2";
    try{
        $connection = new mysqli($host, $user, $password, $dbname);
        $connection->set_charset("utf8mb4");
    }catch(mysqli_sql_exception $e){
        die("Error de conexión: " . $e->getMessage());
    }
    return $connection;
}

function addJugador($nombre, $dni, $dorsal, $posicion, $equipo, $goles){
    $connection = getConnection();
    
    // Si posicion es un array, convertirlo a string
    if(is_array($posicion)){
        // la funcion implode convierte a string con un separador que nosotros usemos en este caso ','  
        $posicion = implode(',', $posicion);
    }
    
    $sql = "INSERT INTO jugadores(nombre, dni, dorsal, posicion, equipo, goles) VALUES(?,?,?,?,?,?)";
    $stmt = $connection->prepare($sql);
    
    if($stmt === false){
        die("Error en la preparacion: " . $connection->error);
    }
    
    $stmt->bind_param("ssissi", $nombre, $dni, $dorsal, $posicion, $equipo, $goles);
    
    if($stmt->execute()){
        echo "Jugador insertado correctamente. Filas afectadas: " . $stmt->affected_rows . "<br>";
    }else{
        echo "Error de insercion: " . $stmt->error . "<br>";
    }
    
    $stmt->close();
    $connection->close();
}

function getAllJugadores(){
    $connection = getConnection();
    $sql = "SELECT * FROM jugadores";
    try{
        $result = $connection->query($sql);
        return $result;
    }catch(mysqli_sql_exception $e){
        echo "Error: " . $e->getMessage();
        return null;
    }
}

function buscarJugador($campo, $valor){
    $connection = getConnection();
    
    $campos_permitidos = ['dni', 'equipo', 'posicion'];
    
    if(!in_array($campo, $campos_permitidos)){
        return null;
    }
    
    $sql = "SELECT * FROM jugadores WHERE $campo LIKE ?";
    $stmt = $connection->prepare($sql);
    // usamos '%' tanto al principio como al final porque queremos que contenga esa palabra
    $valor_busqueda = "%$valor%";
    $stmt->bind_param("s", $valor_busqueda);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result;
}

function existeJugador($dni){
    $connection = getConnection();
    $sql = "SELECT * FROM jugadores WHERE dni = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $dni);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->num_rows > 0 ? $result->fetch_object() : null;
}

function modificarJugador($dni, $nombre, $dorsal, $posicion, $equipo, $goles){
    $connection = getConnection();
    
    // Si posicion es un array, convertirlo a string
    if(is_array($posicion)){
            // la funcion implode convierte a string con un separador que nosotros usemos en este caso ','  
        $posicion = implode(',', $posicion);
    }
    
    $sql = "UPDATE jugadores SET nombre=?, dorsal=?, posicion=?, equipo=?, goles=? WHERE dni=?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("sissis", $nombre, $dorsal, $posicion, $equipo, $goles, $dni);
    
    if($stmt->execute()){
        echo "Jugador modificado correctamente. Filas afectadas: " . $stmt->affected_rows . "<br>";
        return true;
    }else{
        echo "Error al modificar: " . $stmt->error . "<br>";
        return false;
    }
}
?>