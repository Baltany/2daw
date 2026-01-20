<?php
require_once '../model/Conexion.php';
require_once '../model/Profesor.php';
class ProfesorController{

    public static function buscarPorUsuario($usuario){
        try{
            $conex = new Conexion();
            $pdo = $conex ->getConexion();

            $sql = "SELECT * FROM profesor WHERE usuario = :usuario";
            $stmt = $pdo -> prepare($sql);
            $stmt -> execute([':usuario' => $usuario]);

            if($stmt -> rowCount()){
                $reg = $stmt -> fetch(PDO::FETCH_OBJ);
                $u = new Profesor($reg->codigo,$reg->usuario,$reg->nombrecompleto,$reg->email,$reg->clave,$reg->telf,$reg->rol,$reg->intentos_fallidos,$reg->bloqueo_hasta,$reg->ultimo_acceso);
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