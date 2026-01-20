<?php
session_start();

// CORRECCIÓN: Verificar sesión en lugar de cookie
if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
    exit();
}

require_once '../model/Usuario.php';

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
    
    <p>Bienvenido/a: <?php echo $usuario->nombre; ?> 
    <a href="logout.php">Cerrar Sesión</a></p>
    
    <hr>
    
    <h2>MENÚ</h2>
    <ul>
        <?php if($usuario->esDuenio()): ?>
            <li><a href="mis_mascotas.php">Mis Mascotas</a></li>
            <li><a href="registrar_mascota.php">Registrar Nueva Mascota</a></li>
            <li><a href="ver_citas.php">Ver Citas de Mis Mascotas</a></li>

        <?php else: ?>
            <li><a href="registrar_cita.php">Registrar Nueva Cita</a></li>
            <li><a href="ver_citas.php">Ver Citas de Hoy</a></li>

        <?php endif; ?>
    </ul>
</body>
</html>