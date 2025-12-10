<?php
require_once 'Conexion.php';
require_once '../model/Empleado.php';

class EmpleadoController{
public static function verificarEmpleado($email, $pass) {
        try {
            $conex = new Conexion();
            $passMD5 = md5($pass);
            
            $stmt = $conex->prepare("SELECT * FROM empleado WHERE email = ? AND pass = ?");
            $stmt->execute([$email, $passMD5]);
            
            if ($stmt->rowCount() > 0) {
                $e = $stmt->fetch(PDO::FETCH_OBJ);
                return new Empleado($e->id, $e->email, $e->pass, $e->nombre, $e->salario, $e->departamento);
            } else {
                return null;
            }
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            return null;
        }
    }
    
    public static function getEmpleadosDept($dep) {
        try {
            $conex = new Conexion();
            $stmt = $conex->prepare("SELECT * FROM empleado WHERE departamento = ?");
            $stmt->execute([$dep]);
            
            $array = [];
            while ($e = $stmt->fetch(PDO::FETCH_OBJ)) {
                $array[] = new Empleado($e->id, $e->email, $e->pass, $e->nombre, $e->salario, $e->departamento);
            }
            
            return $array;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            return [];
        }
    }

}

?>