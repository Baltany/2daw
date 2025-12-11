<?php
session_start();

// Verificar si la cookie existe y tiene un valor válido
if(!isset($_COOKIE['usuario_id']) || empty($_COOKIE['usuario_id'])){
    header("Location: login.php");
    exit();
}

require_once '../model/Usuario.php';
require_once '../controller/UsuarioController.php';

$usuario = UsuarioController::buscarPorId($_COOKIE['usuario_id']);

// Verificar que el usuario existe
if(!$usuario){
    // Si no se encuentra el usuario, limpiar cookies y redirigir al login
    setcookie("usuario_id", "", time()-3600, "/");
    setcookie("usuario_nombre", "", time()-3600, "/");
    setcookie("usuario_apellidos", "", time()-3600, "/");
    setcookie("usuario_dni", "", time()-3600, "/");
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Usuario</title>
</head>
<body>
    <h1>Panel de Usuario</h1>
    
    <p>Bienvenido/a: <?php echo $usuario->nombre . ' ' . $usuario->apellidos; ?></p>
    
    <a href="logout.php">Cerrar Sesión</a> | <a href="items.php">Gestionar Items</a>
    
    <hr>
    
    <h2>Tus Datos Registrados</h2>
    
    <table border="1">
        <tr>
            <th>Campo</th>
            <th>Valor</th>
        </tr>
        <tr>
            <td>DNI</td>
            <td><?php echo $usuario->dni; ?></td>
        </tr>
        <tr>
            <td>Nombre</td>
            <td><?php echo $usuario->nombre; ?></td>
        </tr>
        <tr>
            <td>Apellidos</td>
            <td><?php echo $usuario->apellidos; ?></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><?php echo $usuario->email; ?></td>
        </tr>
        <tr>
            <td>Provincia</td>
            <td><?php echo $usuario->provincia ? $usuario->provincia : 'No especificada'; ?></td>
        </tr>
        <tr>
            <td>Sexo</td>
            <td><?php echo $usuario->sexo ? $usuario->sexo : 'No especificado'; ?></td>
        </tr>
        <tr>
            <td>Edad</td>
            <td><?php echo $usuario->edad ? $usuario->edad . ' años' : 'No especificada'; ?></td>
        </tr>
        <tr>
            <td>Estado Civil</td>
            <td><?php echo $usuario->estado_civil ? $usuario->estado_civil : 'No especificado'; ?></td>
        </tr>
        <tr>
            <td>Aficiones</td>
            <td><?php echo $usuario->aficiones ? $usuario->aficiones : 'No especificadas'; ?></td>
        </tr>
        <tr>
            <td>Estudios</td>
            <td><?php echo $usuario->estudios ? $usuario->estudios : 'No especificados'; ?></td>
        </tr>
        <tr>
            <td>Fecha de Registro</td>
            <td><?php echo date('d/m/Y H:i', strtotime($usuario->fecha_registro)); ?></td>
        </tr>
    </table>
</body>
</html>