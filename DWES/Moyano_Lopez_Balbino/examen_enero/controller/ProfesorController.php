<?php
require_once '../model/Conexion.php';
require_once '../model/Profesor.php';

class ProfesorController{

    public static function buscarPorDni($dni_p){
        try{
            $conex = new Conexion();
            $pdo = $conex->getConexion();

            $sql = "SELECT * FROM profesores WHERE dni_p = :dni_p";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':dni_p' => $dni_p]);

            if($stmt->rowCount()){
                $reg = $stmt->fetch(PDO::FETCH_OBJ);
                $p = new Profesor(
                    $reg->dni_p,
                    $reg->nombre,
                    $reg->pass,
                    $reg->bloqueado,
                    $reg->apellidos,
                    $reg->hora_bloqueo,
                    $reg->intentos
                );
            }else{
                $p = false;
            }
            return $p;
        }catch(PDOException $ex){
            die("Error con la bd: " . $ex->getMessage());
        }
    }

    public static function estaBloqueado($dni_p){
        try{
            $conex = new Conexion();
            $pdo = $conex->getConexion();

            $sql = "SELECT intentos FROM profesores WHERE dni_p = :dni_p";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':dni_p' => $dni_p]);

            if($stmt->rowCount()){
                $reg = $stmt->fetch(PDO::FETCH_OBJ);
                return $reg->intentos >= 3;
            }
            return false;
        }catch(PDOException $ex){
            die("Error: " . $ex->getMessage());
        }
    }

    public static function registrarIntentoFallido($dni_p){
        try{
            $conex = new Conexion();
            $pdo = $conex->getConexion();

            $sql = "UPDATE profesores 
                    SET intentos = intentos + 1 
                    WHERE dni_p = :dni_p";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':dni_p' => $dni_p]);

            $sql = "SELECT intentos FROM profesores WHERE dni_p = :dni_p";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':dni_p' => $dni_p]);
            $reg = $stmt->fetch(PDO::FETCH_OBJ);
            
            return $reg->intentos;
        }catch(PDOException $ex){
            die("Error: " . $ex->getMessage());
        }
    }

    public static function resetearIntentos($dni_p){
        try{
            $conex = new Conexion();
            $pdo = $conex->getConexion();

            $sql = "UPDATE profesores
                    SET intentos = 0,
                        hora_bloqueo= NOW()
                    WHERE dni_p = :dni_p";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':dni_p' => $dni_p]);
        }catch(PDOException $ex){
            die("Error: " . $ex->getMessage());
        }
    }
}
?>