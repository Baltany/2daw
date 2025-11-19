<?php
function getConnection(){
    try{
        $opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
        $connection = new PDO('mysql:host=localhost;dbname=autobuses', 'dwes', 'abc123.', $opciones);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
        die("Error de conexión: " . $e->getMessage());
    }
    return $connection;
}

function addBus($matricula, $marca, $plazas){
    $connection = getConnection();
    try{
        $sql = "INSERT INTO autos (Matricula, Marca, Num_plazas) VALUES (?, ?, ?)";
        $stmt = $connection->prepare($sql);
        $stmt->execute([$matricula, $marca, $plazas]);
        return true;
    }catch(PDOException $e){
        echo $e->getMessage();
        return false;
    }
}

function getBus(){
    $connection = getConnection();
    try{
        $stmt = $connection->query("SELECT * FROM autos ORDER BY Matricula");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }catch(PDOException $e){
        echo $e->getMessage();
        return [];
    }
}

function getBusMatricula($matricula){
    $connection = getConnection();
    try{
        $sql = "SELECT * FROM autos WHERE Matricula = ?";
        $stmt = $connection->prepare($sql);
        $stmt->execute([$matricula]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }catch(PDOException $e){
        echo $e->getMessage();
        return null;
    }
}

function addViaje($fecha, $matricula, $origen, $destino, $plazasLibres){
    $connection = getConnection();
    try{
        $sql = "INSERT INTO viajes (Fecha, Matricula, Origen, Destino, Plazas_libres) VALUES (?, ?, ?, ?, ?)";
        $stmt = $connection->prepare($sql);
        $stmt->execute([$fecha, $matricula, $origen, $destino, $plazasLibres]);
        return true;
    }catch(PDOException $e){
        echo $e->getMessage();
        return false;
    }
}

function getAllViajes(){
    $connection = getConnection();
    try{
        $stmt = $connection->query("SELECT * FROM viajes ORDER BY Fecha, Origen, Destino");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }catch(PDOException $e){
        echo $e->getMessage();
        return [];
    }
}

function modificarViaje($fecha, $origen, $destino, $matricula, $plazasLibres){
    $connection = getConnection();
    try{
        $sql = "UPDATE viajes SET Matricula = ?, Plazas_libres = ? 
                WHERE Fecha = ? AND Origen = ? AND Destino = ?";
        $stmt = $connection->prepare($sql);
        $stmt->execute([$matricula, $plazasLibres, $fecha, $origen, $destino]);
        return $stmt->rowCount() > 0;
    }catch(PDOException $e){
        echo $e->getMessage();
        return false;
    }
}

function borrarViaje($fecha, $origen, $destino){
    $connection = getConnection();
    try{
        $sql = "DELETE FROM viajes WHERE Fecha = ? AND Origen = ? AND Destino = ?";
        $stmt = $connection->prepare($sql);
        $stmt->execute([$fecha, $origen, $destino]);
        return $stmt->rowCount() > 0;
    }catch(PDOException $e){
        echo $e->getMessage();
        return false;
    }
}

function getOrigenesDisponibles(){
    $connection = getConnection();
    try{
        $stmt = $connection->query("SELECT DISTINCT Origen FROM viajes ORDER BY Origen");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }catch(PDOException $e){
        echo $e->getMessage();
        return [];
    }
}

function getDestinosDisponibles(){
    $connection = getConnection();
    try{
        $stmt = $connection->query("SELECT DISTINCT Destino FROM viajes ORDER BY Destino");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }catch(PDOException $e){
        echo $e->getMessage();
        return [];
    }
}

function consultarViaje($fecha, $origen, $destino){
    $connection = getConnection();
    try{
        $sql = "SELECT * FROM viajes WHERE Fecha = ? AND Origen = ? AND Destino = ?";
        $stmt = $connection->prepare($sql);
        $stmt->execute([$fecha, $origen, $destino]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }catch(PDOException $e){
        echo $e->getMessage();
        return null;
    }
}

function reservarAsiento($fecha, $origen, $destino){
    $connection = getConnection();
    try{
        // Verificamos que todavia hay asientos
        $viaje = consultarViaje($fecha, $origen, $destino);

        if($viaje && $viaje->Plazas_libres > 0){
            $sql = "UPDATE viajes SET Plazas_libres = Plazas_libres - 1 
                    WHERE Fecha = ? AND Origen = ? AND Destino = ? AND Plazas_libres > 0";
            $stmt = $connection->prepare($sql);
            $stmt->execute([$fecha, $origen, $destino]);

            if($stmt->rowCount() > 0){
                return true;
            }
        }
        return false;
    }catch(PDOException $e){
        echo $e->getMessage();
        return false;
    }
}
?>