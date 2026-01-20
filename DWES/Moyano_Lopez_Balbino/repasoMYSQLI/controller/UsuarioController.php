<?php
require_once '../model/Conexion.php';
require_once '../model/Usuario.php';

class UsuarioController{
public static function buscarPorEmail($email){
    try{
        $conex = new Conexion();
        $sql = "SELECT * FROM usuario WHERE email = ?";
        $stmt= $conex->prepare($sql);

        if(!$stmt){
            throw new Exception("Error en prepare: " . $conex->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();

        if($result->num_rows > 0){
            $reg = $result->fetch_object();
            $u = new Usuario(
                $reg->id,
                $reg->nombre,
                $reg->email,
                $reg->clave,
                $reg->rol,
                $reg->fecha_creacion
            );
        }else{
            $u = false;
        }

        $stmt->close();
        return $u;

    }catch(Exception $ex){
        die("Error con la bd: " . $ex->getMessage());
    }
}

}



?>