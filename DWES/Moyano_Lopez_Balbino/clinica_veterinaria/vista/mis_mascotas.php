<?php
session_start();

// CORRECCIÓN: Verificar sesión en lugar de cookie
if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
    exit();
}

require_once '../model/Usuario.php';
require_once '../model/Mascota.php';
require_once '../controller/MascotaController.php';

// CORRECCIÓN: Obtener usuario de sesión
$usuario = unserialize($_SESSION['usuario']);
//Protegiendo la ruta
if(!$usuario->esDuenio()) {
    header("Location: menu.php");
    exit();
}

$mascotas = MascotaController::mostrarMascotas($usuario->id);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis mascotas</title>
</head>
<body>
    <h1>Panel de <?php echo $usuario->rol; ?></h1>
    
    <p>Bienvenido/a: <?php echo $usuario->nombre; ?> 
    <a href="logout.php">Cerrar Sesión</a></p>
    
    <hr>
    
    <h2>Mascotas registradas</h2>
    <?php if ($mascotas && count($mascotas) > 0): ?>
    <table border="1">
        <tr>
            <td>Nombre</td>
            <td>Especie</td>
            <td>Raza</td>
            <td>Edad</td>
            <td>Foto</td>
            <td>Acciones</td>
        </tr>
        <?php foreach ($mascotas as $mascota): ?>
        <tr>
            <td><?= $mascota->nombre ?></td>
            <td><?= $mascota->especie ?></td>
            <td><?= $mascota->raza ?></td>
            <td><?= $mascota->edad ?></td>
            <td>
                <img src="../imagenes/<?= $mascota->foto ?>" width="80">
            </td>
            <td>
                <a href="ver_citas.php?id=<?= $mascota->id ?>">Ver citas</a> |
                <a href="registrar_mascota.php?id=<?= $mascota->id ?>">Editar</a> |
                <a href="registrar_mascota.php">Registrar mascota</a>

            </td>

        </tr>
        <?php endforeach; ?>
    </table>
    <?php else: ?>
    <p>No tienes mascotas registradas.</p>
    <?php endif; ?>
    <br>
    <a href="menu.php">Volver al menú</a>

</body>
</html>