<?php
require_once '../model/ConexionMysqli.php';
require_once '../model/Usuario.php';

class UsuarioController{
    public static function insertar($u){
        try{
            $conex=new ConexionMysqli();
            $conex->query("INSERT INTO usuarios (dni,nombre,apellidos,email,password,provincia,sexo,edad,estado_civil,aficiones,estudios,tipo) VALUES ('$u->dni','$u->nombre','$u->apellidos','$u->email','$u->password','$u->provincia','$u->sexo',$u->edad,'$u->estado_civil','$u->aficiones','$u->estudios','$u->tipo')");
            $filas=$conex->affected_rows;
            $conex->close();
            return $filas;
        } catch (Exception $ex) {
            echo "<a href=../view/registro.php>Ir a registro</a>";
            die("ERROR CON LA BD: ".$ex->getMessage());
        }
    }
    
    public static function actualizar($u){
        try{
            $conex = new ConexionMysqli();

            $sql = "
                UPDATE usuarios SET 
                    dni='$u->dni',
                    nombre='$u->nombre',
                    apellidos='$u->apellidos',
                    email='$u->email',
                    provincia='$u->provincia',
                    sexo='$u->sexo',
                    edad='$u->edad',
                    estado_civil='$u->estado_civil',
                    aficiones='$u->aficiones',
                    estudios='$u->estudios',
                    tipo='$u->tipo'
                WHERE id=$u->id
            ";

            $conex->query($sql);

            $filas = $conex->affected_rows;

            $conex->close();
            return $filas;

        } catch(Exception $ex){
            echo "<a href='../view/admin.php'>Ir a admin</a>";
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }

    public static function buscarPorEmail($email){
        try{
            $conex=new ConexionMysqli();
            $result=$conex->query("SELECT * FROM usuarios WHERE email='$email'");
            if($result->num_rows){
                $reg=$result->fetch_object();
                $u=new Usuario($reg->id,$reg->dni,$reg->nombre,$reg->apellidos,$reg->email,$reg->password,$reg->provincia,$reg->sexo,$reg->edad,$reg->estado_civil,$reg->aficiones,$reg->estudios,$reg->fecha_registro,$reg->tipo);
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
                $u=new Usuario($reg->id,$reg->dni,$reg->nombre,$reg->apellidos,$reg->email,$reg->password,$reg->provincia,$reg->sexo,$reg->edad,$reg->estado_civil,$reg->aficiones,$reg->estudios,$reg->fecha_registro,$reg->tipo);
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
                $u=new Usuario($reg->id,$reg->dni,$reg->nombre,$reg->apellidos,$reg->email,$reg->password,$reg->provincia,$reg->sexo,$reg->edad,$reg->estado_civil,$reg->aficiones,$reg->estudios,$reg->fecha_registro,$reg->tipo);
            }
            else
                $u=false;
            $conex->close();
            return $u;
        } catch (Exception $ex) {
            die("ERROR CON LA BD: ".$ex->getMessage());
        }
    }
    
    public static function obtenerTodos(){
        try{
            $conex=new ConexionMysqli();
            $result=$conex->query("SELECT * FROM usuarios ORDER BY fecha_registro DESC");
            $usuarios=array();
            if($result->num_rows){
                while($reg=$result->fetch_object()){
                    $u=new Usuario($reg->id,$reg->dni,$reg->nombre,$reg->apellidos,$reg->email,$reg->password,$reg->provincia,$reg->sexo,$reg->edad,$reg->estado_civil,$reg->aficiones,$reg->estudios,$reg->fecha_registro,$reg->tipo);
                    $usuarios[]=$u;
                }
            }
            $conex->close();
            return $usuarios;
        } catch (Exception $ex) {
            die("ERROR CON LA BD: ".$ex->getMessage());
        }
    }
    
    public static function eliminar($id){
        try{
            $conex=new ConexionMysqli();
            $conex->query("DELETE FROM usuarios WHERE id=$id");
            $filas=$conex->affected_rows;
            $conex->close();
            return $filas;
        } catch (Exception $ex) {
            die("ERROR CON LA BD: ".$ex->getMessage());
        }
    }
}
?>