<?php
require_once '../model/Conexion.php';
require_once '../model/Coche.php';

class CocheController{
    
    public static function buscarPorMatricula($matricula){
        try{
            $conex = new Conexion();
            $pdo = $conex->getConexion();
            
            $sql = "SELECT * FROM coche WHERE matricula = :matricula";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':matricula' => $matricula]);
            
            if($stmt->rowCount()){
                $reg = $stmt->fetch(PDO::FETCH_OBJ);
                $c = new Coche($reg->matricula, $reg->marca, $reg->modelo, $reg->km, $reg->foto, $reg->dni_cliente);
            }else{
                $c = false;
            }
            return $c;
        }catch(PDOException $ex){
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
    
    public static function mostrarPorDni($dni_cliente){
        try{
            $conex = new Conexion();
            $pdo = $conex->getConexion();

            $sql = "SELECT * FROM coche WHERE dni_cliente = :dni_cliente ORDER BY matricula";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':dni_cliente' => $dni_cliente]);
            
            $coches = array();
            if($stmt->rowCount()){
                while($fila = $stmt->fetch(PDO::FETCH_OBJ)){
                    $coche = new Coche($fila->matricula, $fila->marca, $fila->modelo, $fila->km, $fila->foto, $fila->dni_cliente);
                    $coches[] = $coche;
                }
            }else{
                $coches = false;
            }
            return $coches;            
        }catch(PDOException $ex){
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
    
    public static function insertar($coche){
        try{
            $conex = new Conexion();
            $pdo = $conex->getConexion();
            
            $sql = "INSERT INTO coche (matricula, marca, modelo, km, foto, dni_cliente) VALUES (:matricula, :marca, :modelo, :km, :foto, :dni_cliente)";
            $stmt = $pdo->prepare($sql);
            $resultado = $stmt->execute([
                ':matricula' => $coche->matricula,
                ':marca' => $coche->marca,
                ':modelo' => $coche->modelo,
                ':km' => $coche->km,
                ':foto' => $coche->foto,
                ':dni_cliente' => $coche->dni_cliente
            ]);
            
            return $resultado ? $stmt->rowCount() : 0;
        }catch(PDOException $ex){
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
    
    public static function actualizar($coche){
        try{
            $conex = new Conexion();
            $pdo = $conex->getConexion();
            
            $sql = "UPDATE coche SET marca = :marca, modelo = :modelo, km = :km, foto = :foto WHERE matricula = :matricula";
            $stmt = $pdo->prepare($sql);
            $resultado = $stmt->execute([
                ':marca' => $coche->marca,
                ':modelo' => $coche->modelo,
                ':km' => $coche->km,
                ':foto' => $coche->foto,
                ':matricula' => $coche->matricula
            ]);
            
            return $resultado ? $stmt->rowCount() : 0;
        }catch(PDOException $ex){
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
}
?>