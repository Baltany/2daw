<?php
require_once 'model/Alquiler.php';

class AlquilerController{
    
    public static function alquilar(){
        if(isset($_POST['alquilar'])){
            // La sesión ya está iniciada en index.php
            if(!isset($_SESSION['cliente'])){
                header("Location: index.php?accion=login&mensaje=Debe loguearse para alquilar");
                exit();
            }
            
            $cliente = unserialize($_SESSION['cliente']);
            $cod_juego = $_POST['cod_juego'];
            $fecha_actual = date('Y-m-d');
            
            $alquiler = new Alquiler(0, $cod_juego, $cliente->DNI, $fecha_actual, null);
            
            if($alquiler->alquilar()){
                return "Juego alquilado correctamente";
            }else{
                return "Error al alquilar el juego";
            }
        }
    }
    
    public static function devolver(){
        if(isset($_POST['devolver'])){
            $id = $_POST['id_alquiler'];
            if(Alquiler::devolver($id)){
                return "Juego devuelto correctamente";
            }else{
                return "Error al devolver el juego";
            }
        }
    }
    
    public static function misAlquileres($dni_cliente){
        return Alquiler::misAlquileres($dni_cliente);
    }
    
    public static function listarAlquilados(){
        return Alquiler::mostrarAlquilados();
    }
    
    public static function detalleAlquiler($cod_juego){
        return Alquiler::detalleAlquiler($cod_juego);
    }
}
?>