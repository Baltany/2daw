<?php
require_once 'Conexion.php';
require_once '../model/Tarea.php';

class TareasController{
public static function crearTarea($empleado_id, $fini, $ffin, $horas) {
        try {
            $conex = new Conexion();
            $stmt = $conex->prepare("INSERT INTO tareas (empleado_id, fecha_inicio, fecha_fin, horas) VALUES (?, ?, ?, ?)");
            $stmt->execute([$empleado_id, $fini, $ffin, $horas]);
            
            return $stmt->rowCount() > 0;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            return false;
        }
    }

    public static function getTareas($empleado_id) {
        try {
            $conex = new Conexion();
            $stmt = $conex->prepare("SELECT * FROM tareas WHERE empleado_id = ?");
            $stmt->execute([$empleado_id]);
            
            if ($stmt->rowCount() > 0) {
                $tareas = [];
                while ($t = $stmt->fetch(PDO::FETCH_OBJ)) {
                    $tareas[] = new Tarea($t->id, $t->empleado_id, $t->fecha_inicio, $t->fecha_fin, $t->horas);
                }
                return $tareas;
            }
            return [];
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            return [];
        }
    }

    public static function modificarTarea($id, $horas) {
        try {
            $conex = new Conexion();
            $stmt = $conex->prepare("UPDATE tareas SET horas = ? WHERE id = ?");
            $stmt->execute([$horas, $id]);
            
            return $stmt->rowCount() > 0;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            return false;
        }
    }
    
    public static function eliminarTarea($id) {
        try {
            $conex = new Conexion();
            $stmt = $conex->prepare("DELETE FROM tareas WHERE id = ?");
            $stmt->execute([$id]);
            
            return $stmt->rowCount() > 0;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            return false;
        }
    }

}

?>