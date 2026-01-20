<?php
session_start();

$_SESSION = array();

if(isset($_COOKIE[session_name()])){
    setcookie(session_name(), '', time() - 3600, '/');
}

// Eliminar cookie de recordar si existe
if(isset($_COOKIE['recordar_usuario'])){
    setcookie('recordar_usuario', '', time() - 3600, '/');
}

session_destroy();

header("Location: login3.php");
exit();
?>