<?php
require_once '../model/Conexion.php';
require_once '../model/Mascota.php';


class MascotaController{
    public static function mostrarMascotas($id_usuario){
        try{
            $conex = new Conexion();
            $pdo = $conex->getConexion();
            
            $sql = "SELECT * FROM mascota WHERE id_usuario = :id_usuario";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id_usuario' => $id_usuario]);

            
            $mascotas = array();
            if($stmt->rowCount()){
                while($fila = $stmt->fetch(PDO::FETCH_OBJ)){
                    $m = new Mascota($fila->id, $fila->nombre, $fila->especie,
                    $fila->raza, $fila->edad, $fila->foto,$fila->id_usuario,
                    $fila->fecha_registro);
                    $mascotas[] = $m;
                }
            }else{
                $mascotas = false;
            }
            return $mascotas;
        }catch(PDOException $ex){
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
    public static function buscarPorId($id){
    try{
        $conex = new Conexion();
        $pdo = $conex->getConexion();
        
        $sql = "SELECT * FROM mascota WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        
        if($stmt->rowCount()){
            $fila = $stmt->fetch(PDO::FETCH_OBJ);
            $mascota = new Mascota(
                $fila->id, 
                $fila->nombre, 
                $fila->especie,
                $fila->raza, 
                $fila->edad, 
                $fila->foto, 
                $fila->id_usuario,
                $fila->fecha_registro
            );
        } else {
            $mascota = false;
        }
        return $mascota;
    }catch(PDOException $ex){
        die("ERROR CON LA BD: " . $ex->getMessage());
    }
    }

    public static function insertar($mascota){
        try{
            $conex = new Conexion();
            $pdo = $conex->getConexion();
            
            // NO incluir :id en el INSERT - MySQL lo genera automáticamente
            $sql = "INSERT INTO mascota (nombre, especie, raza, edad, foto, id_usuario, fecha_registro) 
                    VALUES (:nombre, :especie, :raza, :edad, :foto, :id_usuario, :fecha_registro)";
            $stmt = $pdo->prepare($sql);
            
            $resultado = $stmt->execute([
                ':nombre' => $mascota->nombre,
                ':especie' => $mascota->especie,
                ':raza' => $mascota->raza,
                ':edad' => $mascota->edad,
                ':foto' => $mascota->foto,
                ':id_usuario' => $mascota->id_usuario,
                ':fecha_registro' => date('Y-m-d H:i:s')
            ]);
            
            return $resultado ? true : false;
        }catch(PDOException $ex){
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }

    // 4. Actualizar mascota existente
    public static function actualizar($mascota){
        try{
            $conex = new Conexion();
            $pdo = $conex->getConexion();
            
            $sql = "UPDATE mascota SET nombre = :nombre, especie = :especie, raza = :raza, 
                    edad = :edad, foto = :foto WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            
            $resultado = $stmt->execute([
                ':nombre' => $mascota->nombre,
                ':especie' => $mascota->especie,
                ':raza' => $mascota->raza,
                ':edad' => $mascota->edad,
                ':foto' => $mascota->foto,
                ':id' => $mascota->id
            ]);
            
            return $resultado ? true : false;
        }catch(PDOException $ex){
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }

}

?>