<?php
session_start();

// CORRECCIÓN: Verificar sesión en lugar de cookie
if(!isset($_SESSION['usuario'])){
    header("Location: login3.php");
    exit();
}

require_once '../model/Profesor.php';

// CORRECCIÓN: Obtener empleado de sesión
$usuario = unserialize($_SESSION['usuario']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu-Balbino</title>
</head>

<body>
    <h1>Panel de <?php echo $usuario->rol; ?></h1>

    <p>Bienvenido/a: <?php echo $usuario->nombrecompleto; ?>
        <a href="logout3.php">Cerrar Sesión</a>
    </p>

    <hr>

    <h2>MENÚ</h2>
</body>

</html>