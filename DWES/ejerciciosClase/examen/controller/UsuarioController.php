<?php
require_once '../model/ConexionMysqli.php';
require_once '../model/Usuario.php';

class UsuarioController{
    public static function insertar($u){
        try{
            $conex=new ConexionMysqli();
            $conex->query("INSERT INTO usuarios (dni,nombre,apellidos,email,password,provincia,sexo,edad,estado_civil,aficiones,estudios) VALUES ('$u->dni','$u->nombre','$u->apellidos','$u->email','$u->password','$u->provincia','$u->sexo',$u->edad,'$u->estado_civil','$u->aficiones','$u->estudios')");
            $filas=$conex->affected_rows;
            $conex->close();
            return $filas;
        } catch (Exception $ex) {
            echo "<a href=../view/registro.php>Ir a registro</a>";
            die("ERROR CON LA BD: ".$ex->getMessage());
        }
    }
    
    public static function buscarPorEmail($email){
        try{
            $conex=new ConexionMysqli();
            $result=$conex->query("SELECT * FROM usuarios WHERE email='$email'");
            if($result->num_rows){
                $reg=$result->fetch_object();
                $u=new Usuario($reg->id,$reg->dni,$reg->nombre,$reg->apellidos,$reg->email,$reg->password,$reg->provincia,$reg->sexo,$reg->edad,$reg->estado_civil,$reg->aficiones,$reg->estudios,$reg->fecha_registro);
            }
            else
                $u=false;
            $conex->close();
            return $u;
        } catch (Exception $ex) {
            echo "<a href=../view/login.php>Ir a login</a>";
            die("ERROR CON LA BD: ".$ex->getMessage());
        }
    }
    
    public static function buscarPorDni($dni){
        try{
            $conex=new ConexionMysqli();
            $result=$conex->query("SELECT * FROM usuarios WHERE dni='$dni'");
            if($result->num_rows){
                $reg=$result->fetch_object();
                $u=new Usuario($reg->id,$reg->dni,$reg->nombre,$reg->apellidos,$reg->email,$reg->password,$reg->provincia,$reg->sexo,$reg->edad,$reg->estado_civil,$reg->aficiones,$reg->estudios,$reg->fecha_registro);
            }
            else
                $u=false;
            $conex->close();
            return $u;
        } catch (Exception $ex) {
            die("ERROR CON LA BD: ".$ex->getMessage());
        }
    }
    
    public static function buscarPorId($id){
        try{
            $conex=new ConexionMysqli();
            $result=$conex->query("SELECT * FROM usuarios WHERE id=$id");
            if($result->num_rows){
                $reg=$result->fetch_object();
                $u=new Usuario($reg->id,$reg->dni,$reg->nombre,$reg->apellidos,$reg->email,$reg->password,$reg->provincia,$reg->sexo,$reg->edad,$reg->estado_civil,$reg->aficiones,$reg->estudios,$reg->fecha_registro);
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