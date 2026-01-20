<?php
require_once '../model/Conexion.php';
require_once '../model/Profesor.php';

class ProfesorController2{

    public static function buscarPorUsuario($usuario){
        try{
            $conex = new Conexion();
            $pdo = $conex->getConexion();

            $sql = "SELECT * FROM profesor WHERE usuario = :usuario";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':usuario' => $usuario]);

            if($stmt->rowCount()){
                $reg = $stmt->fetch(PDO::FETCH_OBJ);
                $u = new Profesor(
                    $reg->codigo,
                    $reg->usuario,
                    $reg->nombrecompleto,
                    $reg->email,
                    $reg->clave,
                    $reg->telf,
                    $reg->rol,
                    $reg->intentos_fallidos,
                    $reg->bloqueado_hasta,
                    $reg->ultimo_acceso
                );
            }else{
                $u = false;
            }
            return $u;
        }catch(PDOException $ex){
            die("Error con la bd: " . $ex->getMessage());
        }
    }

    public static function estaBloqueado($usuario){
        try{
            $conex = new Conexion();
            $pdo = $conex->getConexion();

            $sql = "SELECT intentos_fallidos FROM profesor WHERE usuario = :usuario";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':usuario' => $usuario]);

            if($stmt->rowCount()){
                $reg = $stmt->fetch(PDO::FETCH_OBJ);
                return $reg->intentos_fallidos >= 3;
            }
            return false;
        }catch(PDOException $ex){
            die("Error: " . $ex->getMessage());
        }
    }

    public static function registrarIntentoFallido($usuario){
        try{
            $conex = new Conexion();
            $pdo = $conex->getConexion();

            $sql = "UPDATE profesor 
                    SET intentos_fallidos = intentos_fallidos + 1 
                    WHERE usuario = :usuario";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':usuario' => $usuario]);

            $sql = "SELECT intentos_fallidos FROM profesor WHERE usuario = :usuario";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':usuario' => $usuario]);
            $reg = $stmt->fetch(PDO::FETCH_OBJ);
            
            return $reg->intentos_fallidos;
        }catch(PDOException $ex){
            die("Error: " . $ex->getMessage());
        }
    }

    public static function resetearIntentos($usuario){
        try{
            $conex = new Conexion();
            $pdo = $conex->getConexion();

            $sql = "UPDATE profesor 
                    SET intentos_fallidos = 0,
                        ultimo_acceso = NOW()
                    WHERE usuario = :usuario";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':usuario' => $usuario]);
        }catch(PDOException $ex){
            die("Error: " . $ex->getMessage());
        }
    }
}
?>