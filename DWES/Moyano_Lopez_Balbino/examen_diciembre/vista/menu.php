<?php
session_start();

// CORRECCIÓN: Verificar sesión en lugar de cookie
if(!isset($_SESSION['empleado'])){
    header("Location: login.php");
    exit();
}

require_once '../model/Empleado.php';

// CORRECCIÓN: Obtener empleado de sesión
$empleado = unserialize($_SESSION['empleado']);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Menú</title>
</head>

<body>
    <h1>Panel de <?php echo $empleado->rol; ?></h1>

    <p>Bienvenido/a: <?php echo $empleado->nombre; ?>
        <a href="logout.php">Cerrar Sesión</a>
    </p>

    <hr>

    <h2>MENÚ</h2>
    <ul>
        <?php if($empleado->esAdmin()): ?>
        <li><a href="registrar.php">Registrar trabajo</a></li>
        <?php endif; ?>
        <li><a href="trabajos.php">Consulta de trabajos</a></li>
    </ul>
</body>

</html>