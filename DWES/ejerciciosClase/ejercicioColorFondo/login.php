<?php
session_start();
require_once 'funciones.php';

if(!isset($_SESSION['intentos'])){
    $_SESSION['intentos'] = 0;
}

$error_login = "";
//inicializamos el bloqueo
$bloqueado = false;

// comprobamos si esta bloqueado o no
if($_SESSION['intentos'] >= 3){
    $bloqueado = true;
    // redirigimos a intentos.php
    header("Location: intentos.php");
    exit();
}

// si el formulario NO es esta vacio
// si se envia el formulaario y no esta bloqueado...
if(isset($_POST['enviar']) && !$bloqueado){
    // recigemos datos
    $user = trim($_POST['user']);
    $pass = md5($_POST['pass']);

    // ya existe? se comprueba
    $usuario = existeUsuario($user);

    //si el usuario no existe restamos un intento
    if(!$usuario){
        $_SESSION['intentos']++;
        $error_login = "El usuario no existe, Intentos restantes: " . (3 - $_SESSION['intentos']);

    }
    //si existe comprobamos que esa es su password y logueamos
    else{
        // si la password es la correcta entonces y oslo entonces
        if($usuario -> pass = $pass){
            $_SESSION['intentos'] = 0;
            $_SESSION['logueado'] = true;
            $_SESSION['user'] = $usuario -> user;
            $_SESSION['nombre'] = $usuario -> nombre;
            $_SESSION['apellidos'] = $usuario -> apellidos;


            // Guardar preferencias de los estilos q ha elegido
            $_SESSION["tipo_letra"] = $usuario->tipo_letra;
            $_SESSION["color_letra"] = $usuario->color_letra;
            $_SESSION["color_fondo"] = $usuario->color_fondo;
            $_SESSION["tam_letra"] = $usuario->tam_letra;


            //redirigimos
            header("Location: inicio.php");
            exit();
        }else{
            $_SESSION['intentos']++;
            $error_login = "Contraseña incorrecta. Intentos restantes: ". (3 - $_SESSION['intentos']);

            if($_SESSION['intentos'] >= 3){
                header("Location: intentos.php");
                exit();
            }
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form action="" method="post">
        Usuario : <input type="text" name="user" required><br><br>
        Contraseña : <input type="password" name="pass" required><br><br>
        <input type="submit" name="enviar" value="Enviar">
    </form>
    <?php
        if($error_login) echo "<p style='color:red;'>$error_login</p>";
    ?>
    <br>
    <p><a href="registro.php">Ir al registro</a></p>
</body>
</html>