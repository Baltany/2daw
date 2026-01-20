<?php
require_once '../model/Conexion.php';
require_once '../model/Empleado.php';

class EmpleadoController{

    public static function buscarPorCodigo($codigo){
        try{
            $conex = new Conexion();
            $pdo = $conex->getConexion();
            
            $sql = "SELECT * FROM empleado WHERE codigo = :codigo";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':codigo' => $codigo]);
            
            if($stmt->rowCount()){
                $reg = $stmt->fetch(PDO::FETCH_OBJ);
                $u = new Empleado($reg->codigo, $reg->clave, $reg->nombrecompleto, $reg->telf, $reg->rol);
            }else{
                $u = false;
            }
            return $u;
        }catch(PDOException $ex){
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
    
    public static function mostrarMecanicos(){
        try{
            $conex = new Conexion();
            $pdo = $conex->getConexion();
            
            $sql = "SELECT * FROM empleado WHERE rol = 'mecanico' ORDER BY nombrecompleto";
            $stmt = $pdo->query($sql);
            
            $mecanicos = array();
            if($stmt->rowCount()){
                while($fila = $stmt->fetch(PDO::FETCH_OBJ)){
                    $m = new Empleado($fila->codigo, $fila->clave, $fila->nombrecompleto, $fila->telf, $fila->rol);
                    $mecanicos[] = $m;
                }
            }else{
                $mecanicos = false;
            }
            return $mecanicos;
        }catch(PDOException $ex){
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
}
?>