<?php
require_once '../model/Conexion.php';
require_once '../model/Tarea.php';

class TareaController{
    
    public static function mostrarPorTipo(){
        try{
            $conex = new Conexion();
            $pdo = $conex->getConexion();
            
            $sql = "SELECT * FROM tarea ORDER BY tipo, descripcion";
            $stmt = $pdo->query($sql);
            
            $tareas = array();
            if($stmt->rowCount()){
                while($fila = $stmt->fetch(PDO::FETCH_OBJ)){
                    $t = new Tarea($fila->id, $fila->descripcion, $fila->precio, $fila->tipo);
                    $tareas[] = $t;
                }
            }else{
                $tareas = false;
            }
            return $tareas;
        }catch(PDOException $ex){
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
    
    public static function buscarPorId($id){
        try{
            $conex = new Conexion();
            $pdo = $conex->getConexion();
            
            $sql = "SELECT * FROM tarea WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            
            if($stmt->rowCount()){
                $reg = $stmt->fetch(PDO::FETCH_OBJ);
                $t = new Tarea($reg->id, $reg->descripcion, $reg->precio, $reg->tipo);
            }else{
                $t = false;
            }
            return $t;
        }catch(PDOException $ex){
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
}
?>