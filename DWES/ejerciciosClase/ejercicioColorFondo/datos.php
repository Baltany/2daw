<?php
session_start();
require_once 'funciones.php';

// protegemos la ruta si no esta logueao
if(!isset($_SESSION['logueado']) || !isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

// obtenemos el usuario logueado
$usuario = getUsuarioUser($_SESSION['user']);

$estilo = "font-family: " . $_SESSION["tipo_letra"] . "; 
           color: " . $_SESSION["color_letra"] . "; 
           background-color: " . $_SESSION["color_fondo"] . "; 
           font-size: " . $_SESSION["tam_letra"] . "px;";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos</title>
</head>
<body style="<?php echo $estilo; ?>">
    <p>Hola <?php echo $_SESSION['nombre']; ?></p><br>

    <p>Nombre: <?php echo $usuario -> nombre; ?></p><br>
    <p>Apellidos: <?php echo $usuario -> apellidos; ?></p><br>
    <p>Direccion: <?php echo $usuario -> direccion; ?></p><br>
    <p>Localidad: <?php echo $usuario -> localidad; ?></p><br>
    <p>Email: <?php echo $usuario -> user; ?></p><br>
    <p>Tipo_letra: <?php echo $usuario -> tipo_letra; ?></p><br>
    <p>Color_letra: <?php echo $usuario -> color_letra; ?></p><br>
    <p>Color_fondo: <?php echo $usuario -> color_fondo; ?></p><br>
    <p>Tam_letra: <?php echo $usuario -> tam_letra; ?></p><br>
    <a href="inicio.php">Volver</a>

</body>
</html>