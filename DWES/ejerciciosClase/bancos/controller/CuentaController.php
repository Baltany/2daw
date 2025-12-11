<?php
require_once '../model/Conexion.php';
require_once '../model/Cuenta.php';

class CuentaController{
    public static function insertar($i){
        try{
            $conex=new Conexion();
            $conex->query("INSERT INTO cuentas (nombre,apellidos,provincia,sexo,edad,estado_civil,aficiones,estudios) VALUES ('$i->nombre','$i->apellidos','$i->provincia','$i->sexo','$i->edad','$i->estado_civil','$i->aficiones','$i->estudios')");
            $filas=$conex->affected_rows;
            $conex->close();
            return $filas;
        } catch (Exception $ex) {
            echo "<a href=../view/crear_cuenta.php>Ir a crear cuenta</a>";
            die("ERROR CON LA BD: ".$ex->getMessage());
        }
    }
    
    public static function buscar($id){
        try{
            $conex=new Conexion();
            $result=$conex->query("SELECT * FROM cuentas WHERE id=$id");
            if($result->num_rows){
                $reg=$result->fetch_object();
                $i=new Cuenta($reg->id,$reg->nombre,$reg->apellidos,$reg->provincia,$reg->sexo,$reg->edad,$reg->estado_civil,$reg->aficiones,$reg->estudios,$reg->fecha_creacion);
            }
            else
                $i=false;
            $conex->close();
            return $i;
        } catch (Exception $ex) {
            echo "<a href=../view/cuentas.php>Ir a cuentas</a>";
            die("ERROR CON LA BD: ".$ex->getMessage());
        }
    }
    
    public static function mostrar(){
        try{
            $conex=new Conexion();
            $result=$conex->query("SELECT * FROM cuentas ORDER BY id DESC");
            if($result->num_rows){
                while($fila=$result->fetch_object()){
                    $i=new Cuenta($fila->id,$fila->nombre,$fila->apellidos,$fila->provincia,$fila->sexo,$fila->edad,$fila->estado_civil,$fila->aficiones,$fila->estudios,$fila->fecha_creacion);
                    $cuentas[]=$i;
                }
            }
            else $cuentas=false;
            $conex->close();
            return $cuentas;            
        } catch (Exception $ex) {
            echo "<a href=../view/cuentas.php>Ir a cuentas</a>";
            die("ERROR CON LA BD: ".$ex->getMessage());
        }
    }
    
    public static function actualizar($i){
        try{
            $conex=new Conexion();
            $conex->query("UPDATE cuentas SET nombre='$i->nombre',apellidos='$i->apellidos',provincia='$i->provincia',sexo='$i->sexo',edad='$i->edad',estado_civil='$i->estado_civil',aficiones='$i->aficiones',estudios='$i->estudios' WHERE id=$i->id");
            $filas=$conex->affected_rows;
            $conex->close();
            return $filas;
        } catch (Exception $ex) {
            echo "<a href=../view/cuentas.php>Ir a cuentas</a>";
            die("ERROR CON LA BD: ".$ex->getMessage());
        }
    }
    
    public static function eliminar($id){
        try{
            $conex=new Conexion();
            $conex->query("DELETE FROM cuentas WHERE id=$id");
            $filas=$conex->affected_rows;
            $conex->close();
            return $filas;
        } catch (Exception $ex) {
            echo "<a href=../view/cuentas.php>Ir a cuentas</a>";
            die("ERROR CON LA BD: ".$ex->getMessage());
        }
    }

        public static function obtenerPorDni($dni){
        try{
            $conex=new Conexion();
            $result=$conex->query("SELECT * FROM cuentas WHERE dni_cuenta='$dni'");
            $cuentas = [];
            if($result->num_rows){
                while($reg = $result->fetch_object()){
                    $c = new Cuenta(
                        $reg->iban,
                        $reg->saldo,
                        $reg->dni_cuenta
                    );
                    $cuentas[] = $c;
                }
            } else {
                $cuentas = false;
            }
            $conex->close();
            return $cuentas;
        } catch (Exception $ex) {
            die("ERROR CON LA BD: ".$ex->getMessage());
        }
    }

    
}
?>