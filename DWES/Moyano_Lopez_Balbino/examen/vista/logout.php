<?php
session_start();

// CORRECCIÓN: Eliminar variables de sesión y destruir sesión correctamente
$_SESSION = array(); // Vaciar array de sesión

// Destruir cookie de sesión
if(isset($_COOKIE[session_name()])){
    setcookie(session_name(), '', time() - 3600, '/');
}

// Destruir sesión
session_destroy();

header("Location: login.php");
exit();
?>