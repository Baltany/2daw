<?php
// login_cookies.php
require_once 'modelos/Usuario.php';

if(isset($_POST['login'])){
    $email = trim($_POST['email']);
    $pass = $_POST['pass'];
    
    $usuario = Usuario::login($email, $pass);
    
    if($usuario){
        // Guardar en cookies (serialize para objetos)
        setcookie("usuario", serialize($usuario), time() + (86400 * 30), "/"); // 30 días
        
        // O guardar datos individuales
        // setcookie("id", $usuario->id, time() + (86400 * 30), "/");
        // setcookie("nombre", $usuario->nombre, time() + (86400 * 30), "/");
        
        header("Location: index.php");
        exit();
    }else{
        $error = "Email o contraseña incorrectos";
    }
}
?>

<!-- HTML igual que arriba -->