<?php
session_start();


// protegemos la ruta...
// sino esta logueado redirigimos al login
if(!isset($_SESSION['logueado']) || !isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}
$estilo =  "font-family: " . $_SESSION["tipo_letra"] . "; 
        color: " . $_SESSION["color_letra"] . "; 
        background-color: " . $_SESSION["color_fondo"] . "; 
        font-size: " . $_SESSION["tam_letra"] . "px;";


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
</head>
<body>
    <p>Hola <?php echo $_SESSION['nombre'] ?></p>
    <br>
    <ul>
        <li><a href="datos.php">Ver mis datos</a></li>
        <li><a href="modificar.php">Modificar mis datos</a></li>
    </ul>
    <br>
    <form action="" method="post">
        <input type="submit" name="salir" value="Cerrar Sesion">
    </form>

    <?php
    if(isset($_POST['salir'])){
        session_destroy();
        header("Location: login.php");
        exit();
    }
    
    ?>
</body>
</html>