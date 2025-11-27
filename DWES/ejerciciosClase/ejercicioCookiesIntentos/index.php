<?php
session_start();

// Verificar si está logueado
if(!isset($_COOKIE["email"]) || !isset($_SESSION["logueado"])){
    header("Location: login.php");
    exit();
}

if(isset($_POST['cerrar'])){
    // Destruir sesion
    session_destroy();

    // Borrar cookies
    setcookie("dni", "", time() - 3600, "/");
    setcookie("nombre", "", time() - 3600, "/");
    setcookie("apellidos", "", time() - 3600, "/");
    setcookie("email", "", time() - 3600, "/");
    setcookie("ultimo_acceso", "", time() - 3600, "/");

    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
</head>
<body>
    
    <h2>Tus datos:</h2>
    <p><strong>DNI:</strong> <?php echo $_COOKIE["dni"]; ?></p>
    <p><strong>Nombre:</strong> <?php echo $_COOKIE["nombre"]; ?></p>
    <p><strong>Apellidos:</strong> <?php echo $_COOKIE["apellidos"]; ?></p>
    <p><strong>Email:</strong> <?php echo $_COOKIE["email"]; ?></p>
    
    <?php if(isset($_COOKIE["ultimo_acceso"])): ?>
        <p><strong>Última vez que iniciaste sesión:</strong> <?php echo $_COOKIE["ultimo_acceso"]; ?></p>
    <?php else: ?>
        <p><strong>Esta es tu primera vez iniciando sesión</strong></p>
    <?php endif; ?>
    
    <br>
    <form action="" method="POST">
        <input type="submit" name="cerrar" value="Cerrar Sesión">
    </form>
</body>
</html>