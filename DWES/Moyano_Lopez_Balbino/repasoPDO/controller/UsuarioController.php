<?php
require_once '../model/Conexion.php';
require_once '../model/Usuario.php';
class UsuarioController{

    public static function buscarPorEmail($email){
        try{
            $conex = new Conexion();
            $pdo = $conex ->getConexion();

            $sql = "SELECT * FROM usuario WHERE email = :email";
            $stmt = $pdo -> prepare($sql);
            $stmt -> execute([':email' => $email]);

            if($stmt -> rowCount()){
                $reg = $stmt -> fetch(PDO::FETCH_OBJ);
                $u = new Usuario($reg->id,$reg->nombre,$reg->email,$reg->clave,$reg->rol,$reg->fecha_creacion);
            }else{
                $u = false;
            }
            return $u;
        }catch(PDOException $ex){
            die("Error con la bd: " . $ex->getMessage());
        }
    }
}



?>