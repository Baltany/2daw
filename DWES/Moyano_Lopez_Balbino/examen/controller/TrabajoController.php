<?php
require_once '../model/Conexion.php';
require_once '../model/Trabajo.php';

class TrabajoController{
    
    public static function obtenerPorMecanicoYFecha($cod_mecanico, $fecha){
        try{
            $conex = new Conexion();
            $pdo = $conex->getConexion();
            
            $sql = "SELECT * FROM trabajo WHERE cod_mecanico = :cod_mecanico AND fecha = :fecha ORDER BY matricula, fecha";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':cod_mecanico' => $cod_mecanico, ':fecha' => $fecha]);
            
            $trabajos = array();
            if($stmt->rowCount()){
                while($fila = $stmt->fetch(PDO::FETCH_OBJ)){
                    $t = new Trabajo($fila->matricula, $fila->cod_mecanico, $fila->id_tarea, $fila->fecha, $fila->estado, $fila->horas);
                    $trabajos[] = $t;
                }
            }else{
                $trabajos = false;
            }
            return $trabajos;
        }catch(PDOException $ex){
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
    
    public static function obtenerPorMatriculaYFecha($matricula, $fecha){
        try{
            $conex = new Conexion();
            $pdo = $conex->getConexion();
            
            $sql = "SELECT * FROM trabajo WHERE matricula = :matricula AND fecha = :fecha AND estado != 'Facturada' ORDER BY id_tarea";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':matricula' => $matricula, ':fecha' => $fecha]);
            
            $trabajos = array();
            if($stmt->rowCount()){
                while($fila = $stmt->fetch(PDO::FETCH_OBJ)){
                    $t = new Trabajo($fila->matricula, $fila->cod_mecanico, $fila->id_tarea, $fila->fecha, $fila->estado, $fila->horas);
                    $trabajos[] = $t;
                }
            }else{
                $trabajos = false;
            }
            return $trabajos;
        }catch(PDOException $ex){
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
    
    public static function insertarMultiples($matricula, $cod_mecanico, $tareas_ids, $fecha){
        try{
            $conex = new Conexion();
            $pdo = $conex->getConexion();
            
            // Iniciar transacción
            $pdo->beginTransaction();
            
            $sql = "INSERT INTO trabajo (matricula, cod_mecanico, id_tarea, fecha, estado, horas) VALUES (:matricula, :cod_mecanico, :id_tarea, :fecha, 'Pendiente', 0)";
            $stmt = $pdo->prepare($sql);
            
            foreach($tareas_ids as $id_tarea){
                $stmt->execute([
                    ':matricula' => $matricula,
                    ':cod_mecanico' => $cod_mecanico,
                    ':id_tarea' => $id_tarea,
                    ':fecha' => $fecha
                ]);
            }
            
            $pdo->commit();
            return true;
        }catch(PDOException $ex){
            $pdo->rollBack();
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
    
    public static function actualizar($matricula, $cod_mecanico, $id_tarea, $fecha, $estado, $horas){
        try{
            $conex = new Conexion();
            $pdo = $conex->getConexion();
            
            $sql = "UPDATE trabajo SET estado = :estado, horas = :horas WHERE matricula = :matricula AND cod_mecanico = :cod_mecanico AND id_tarea = :id_tarea AND fecha = :fecha";
            $stmt = $pdo->prepare($sql);
            $resultado = $stmt->execute([
                ':estado' => $estado,
                ':horas' => $horas,
                ':matricula' => $matricula,
                ':cod_mecanico' => $cod_mecanico,
                ':id_tarea' => $id_tarea,
                ':fecha' => $fecha
            ]);
            
            return $resultado ? $stmt->rowCount() : 0;
        }catch(PDOException $ex){
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
    
    public static function facturar($matricula, $fecha){
        try{
            $conex = new Conexion();
            $pdo = $conex->getConexion();
            
            $sql = "UPDATE trabajo SET estado = 'Facturada' WHERE matricula = :matricula AND fecha = :fecha AND estado = 'Completada'";
            $stmt = $pdo->prepare($sql);
            $resultado = $stmt->execute([':matricula' => $matricula, ':fecha' => $fecha]);
            
            return $resultado ? $stmt->rowCount() : 0;
        }catch(PDOException $ex){
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
    

    public static function obtenerTodosPorMecanico($cod_mecanico){
        try{
            $conex = new Conexion();
            $pdo = $conex->getConexion();
            
            $sql = "SELECT * FROM trabajo WHERE cod_mecanico = :cod_mecanico ORDER BY fecha DESC, matricula";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':cod_mecanico' => $cod_mecanico]);
            
            $trabajos = array();
            if($stmt->rowCount()){
                while($fila = $stmt->fetch(PDO::FETCH_OBJ)){
                    $t = new Trabajo($fila->matricula, $fila->cod_mecanico, $fila->id_tarea, $fila->fecha, $fila->estado, $fila->horas);
                    $trabajos[] = $t;
                }
            }else{
                $trabajos = false;
            }
            return $trabajos;
        }catch(PDOException $ex){
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
}
?>