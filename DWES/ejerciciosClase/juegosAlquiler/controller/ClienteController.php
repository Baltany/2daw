<?php
require_once 'model/Cliente.php';

class ClienteController{
    
    public static function login(){
        if(isset($_POST['login'])){
            $dni = trim($_POST['dni']);
            $clave = $_POST['clave'];
            
            $cliente = Cliente::login($dni, $clave);
            
            if($cliente){
                $_SESSION['cliente'] = serialize($cliente);
                header("Location: index.php?accion=menu");
                exit();
            }else{
                return "DNI o contraseña incorrectos";
            }
        }
    }
    
    public static function logout(){
        session_destroy();
        header("Location: index.php");
        exit();
    }
    
    public static function getCliente(){
        if(isset($_SESSION['cliente'])){
            return unserialize($_SESSION['cliente']);
        }
        return null;
    }
}
?>