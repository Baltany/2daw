<?php
require_once '../model/Usuario.php';

class UsuarioController{
    
    public static function login(){
        if(isset($_POST['login'])){
            $dni = trim($_POST['dni']);
            $clave = $_POST['clave'];
            
            $resultado = Usuario::login($dni, $clave);
            
            if(is_object($resultado)){
                // Login exitoso
                $_SESSION['usuario'] = serialize($resultado);
                header("Location: index.php?accion=menu");
                exit();
            }else{
                // Mensaje de error
                return $resultado;
            }
        }
    }
    
    public static function logout(){
        session_destroy();
        header("Location: index.php");
        exit();
    }
}
?>