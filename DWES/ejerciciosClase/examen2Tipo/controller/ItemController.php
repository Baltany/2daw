<?php
require_once '../model/ConexionMysqli.php';
require_once '../model/Item.php';

class ItemController{
    public static function insertar($i){
        try{
            $conex=new ConexionMysqli();
            $conex->query("INSERT INTO items (nombre,apellidos,provincia,sexo,edad,estado_civil,aficiones,estudios) VALUES ('$i->nombre','$i->apellidos','$i->provincia','$i->sexo','$i->edad','$i->estado_civil','$i->aficiones','$i->estudios')");
            $filas=$conex->affected_rows;
            $conex->close();
            return $filas;
        } catch (Exception $ex) {
            echo "<a href=../view/crear_item.php>Ir a crear item</a>";
            die("ERROR CON LA BD: ".$ex->getMessage());
        }
    }
    
    public static function buscar($id){
        try{
            $conex=new ConexionMysqli();
            $result=$conex->query("SELECT * FROM items WHERE id=$id");
            if($result->num_rows){
                $reg=$result->fetch_object();
                $i=new Item($reg->id,$reg->nombre,$reg->apellidos,$reg->provincia,$reg->sexo,$reg->edad,$reg->estado_civil,$reg->aficiones,$reg->estudios,$reg->fecha_creacion);
            }
            else
                $i=false;
            $conex->close();
            return $i;
        } catch (Exception $ex) {
            echo "<a href=../view/items.php>Ir a items</a>";
            die("ERROR CON LA BD: ".$ex->getMessage());
        }
    }
    
    public static function mostrar(){
        try{
            $conex=new ConexionMysqli();
            $result=$conex->query("SELECT * FROM items ORDER BY id DESC");
            if($result->num_rows){
                while($fila=$result->fetch_object()){
                    $i=new Item($fila->id,$fila->nombre,$fila->apellidos,$fila->provincia,$fila->sexo,$fila->edad,$fila->estado_civil,$fila->aficiones,$fila->estudios,$fila->fecha_creacion);
                    $items[]=$i;
                }
            }
            else $items=false;
            $conex->close();
            return $items;            
        } catch (Exception $ex) {
            echo "<a href=../view/items.php>Ir a items</a>";
            die("ERROR CON LA BD: ".$ex->getMessage());
        }
    }
    
    public static function actualizar($i){
        try{
            $conex=new ConexionMysqli();
            $conex->query("UPDATE items SET nombre='$i->nombre',apellidos='$i->apellidos',provincia='$i->provincia',sexo='$i->sexo',edad='$i->edad',estado_civil='$i->estado_civil',aficiones='$i->aficiones',estudios='$i->estudios' WHERE id=$i->id");
            $filas=$conex->affected_rows;
            $conex->close();
            return $filas;
        } catch (Exception $ex) {
            echo "<a href=../view/items.php>Ir a items</a>";
            die("ERROR CON LA BD: ".$ex->getMessage());
        }
    }
    
    public static function eliminar($id){
        try{
            $conex=new ConexionMysqli();
            $conex->query("DELETE FROM items WHERE id=$id");
            $filas=$conex->affected_rows;
            $conex->close();
            return $filas;
        } catch (Exception $ex) {
            echo "<a href=../view/items.php>Ir a items</a>";
            die("ERROR CON LA BD: ".$ex->getMessage());
        }
    }
}
?>