<?php
require_once '../model/Conexion.php';
require_once '../model/Cliente.php';

class ClienteController{
    
    public static function buscarPorDni($dni){
        try{
            $conex = new Conexion();
            $pdo = $conex->getConexion();
            
            $sql = "SELECT * FROM cliente WHERE dni = :dni";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':dni' => $dni]);
            
            if($stmt->rowCount()){
                $reg = $stmt->fetch(PDO::FETCH_OBJ);
                $c = new Cliente($reg->dni, $reg->nombrecompleto, $reg->direccion, $reg->telf);
            }else{
                $c = false;
            }
            return $c;
        }catch(PDOException $ex){
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
    
    public static function actualizar($cliente){
        try{
            $conex = new Conexion();
            $pdo = $conex->getConexion();
            
            $sql = "UPDATE cliente SET nombrecompleto = :nombrecompleto, direccion = :direccion, telf = :telf WHERE dni = :dni";
            $stmt = $pdo->prepare($sql);
            $resultado = $stmt->execute([
                ':nombrecompleto' => $cliente->nombrecompleto,
                ':direccion' => $cliente->direccion,
                ':telf' => $cliente->telf,
                ':dni' => $cliente->dni
            ]);
            
            return $resultado ? $stmt->rowCount() : 0;
        }catch(PDOException $ex){
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
}
?>