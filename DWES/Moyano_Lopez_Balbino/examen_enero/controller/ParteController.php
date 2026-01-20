<?php
require_once '../model/Conexion.php';
require_once '../model/Parte.php';

class ParteController{
    public static function buscarPorDni($dni_a){
        try{
            $conex = new Conexion();
            $pdo = $conex->getConexion();

            $sql = "SELECT * FROM partes WHERE dni_a = :dni_a";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':dni_a' => $dni_a]);

            if($stmt->rowCount()){
                $reg = $stmt->fetch(PDO::FETCH_OBJ);
                $p = new Parte(
                    $reg->dni_p,
                    $reg->dni_a,
                    $reg->time,
                    $reg->foto,
                    $reg->motivo,
                    $reg->id
                );
            }else{
                $p = false;
            }
            return $p;
        }catch(PDOException $ex){
            die("Error con la bd: " . $ex->getMessage());
        }
    }

    public static function insertar($parte){
        try{
            $conex = new Conexion();
            $pdo = $conex->getConexion();
            
            $sql = "INSERT INTO partes (dni_p, dni_a, motivo, time, foto) 
                    VALUES (:dni_p, :dni_a, :motivo, :time, :foto)";
            $stmt = $pdo->prepare($sql);
            
            $resultado = $stmt->execute([
                ':dni_p' => $parte->dni_p,
                ':dni_a' => $parte->dni_a,
                ':motivo' => $parte->motivo,
                ':time' => $parte->time,
                ':foto' => $parte->foto
            ]);
            
            return $resultado ? true : false;
        }catch(PDOException $ex){
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }

    public static function mostrarAlumnos($dni_a){
        try{
            $conex = new Conexion();
            $pdo = $conex->getConexion();
            $sql = "SELECT p.id, p.dni_a, p.time, prof.nombre, p.motivo FROM profesores prof INNER JOIN partes p WHERE prof.dni_p = p.dni_p AND p.dni_a = :dni_a";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([':dni_a' => $dni_a]);

            $partes = array();
            if($stmt->rowCount()){
                while($reg = $stmt->fetch(PDO::FETCH_OBJ)){
                    $a = new Parte(
                        $reg->dni_p,
                        $reg->dni_a,
                        $reg->time,
                        $reg->foto,
                        $reg->motivo,
                        $reg->id
                    );
                    $partes[] = $a;
                }
            }else{
                $partes = false;
            }
            return $partes;
        }catch(PDOException $ex){
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }

    public static function eliminarParte($id){
        try{
            $conex = new Conexion();
            $pdo = $conex->getConexion();
            
            $sql = "DELETE FROM partes WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            
            $resultado = $stmt->execute([':id' => $id]);
            
            return $resultado ? true : false;
        }catch(PDOException $ex){
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
}
?>