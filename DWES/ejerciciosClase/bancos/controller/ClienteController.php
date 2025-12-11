<?php
require_once '../model/Conexion.php';
require_once '../model/Cliente.php';

class ClienteController{
    // public static function insertar($u){
    //     try{
    //         $conex=new Conexion();
    //         $conex->query("INSERT INTO usuarios (nombre,direccion,telefono,dni,clave,intentos,bloqueado) VALUES ('$u->nombre','$u->direccion','$u->telefono','$u->dni','$u->dni','$u->clave','$u->intentos',$u->bloqueado')");
    //         $filas=$conex->affected_rows;
    //         $conex->close();
    //         return $filas;
    //     } catch (Exception $ex) {
    //         echo "<a href=../view/registro.php>Ir a registro</a>";
    //         die("ERROR CON LA BD: ".$ex->getMessage());
    //     }
    // }
    
    // public static function buscarPorEmail($email){
    //     try{
    //         $conex=new Conexion();
    //         $result=$conex->query("SELECT * FROM usuarios WHERE email='$email'");
    //         if($result->num_rows){
    //             $reg=$result->fetch_object();
    //             $u=new Usuario($reg->id,$reg->dni,$reg->nombre,$reg->apellidos,$reg->email,$reg->password,$reg->provincia,$reg->sexo,$reg->edad,$reg->estado_civil,$reg->aficiones,$reg->estudios,$reg->fecha_registro);
    //         }
    //         else
    //             $u=false;
    //         $conex->close();
    //         return $u;
    //     } catch (Exception $ex) {
    //         echo "<a href=../view/login.php>Ir a login</a>";
    //         die("ERROR CON LA BD: ".$ex->getMessage());
    //     }
    // }
    
public static function buscarPorDni($dni){
    try{
        $conex = new Conexion();
        $result = $conex->query("SELECT * FROM usuarios WHERE DNI='$dni'");
        
        if($result->num_rows){
            $reg = $result->fetch_object();

            $u = new Cliente(
                $reg->DNI,
                $reg->Nombre,
                $reg->Direccion,
                $reg->Telefono,
                $reg->clave,
                $reg->intentos,
                $reg->bloqueado
            );
        }
        else{
            $u = false;
        }

        $conex->close();
        return $u;

    } catch (Exception $ex) {
        die("ERROR CON LA BD: ".$ex->getMessage());
    }
}

    
    public static function buscarPorId($id){
        try{
            $conex=new Conexion();
            $result=$conex->query("SELECT * FROM usuarios WHERE id=$id");
            if($result->num_rows){
                $reg=$result->fetch_object();
                $u=new Cliente($reg->nombre,$reg->direccion,$reg->telefono,$reg->clave,$reg->intentos,$reg->bloqueado);
            }
            else
                $u=false;
            $conex->close();
            return $u;
        } catch (Exception $ex) {
            die("ERROR CON LA BD: ".$ex->getMessage());
        }
    }
}
?>