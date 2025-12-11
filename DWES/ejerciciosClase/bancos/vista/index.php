<?php
session_start();
if(isset($_COOKIE['usuario_id'])){
    header("Location:index.php");
}
require_once '../model/Cliente.php';
require_once '../controller/ClienteController.php';

if(isset($_POST['entrar'])){
    $dni=$_POST['dni'];
    $pass=$_POST['pass'];
    
    if(empty($dni)){
        $error_dni="El dni es obligatorio";
    }else{
        $u=ClienteController::buscarPorDni($dni);
        if(!$u){
            $error_dni="El usuario no existe";
        }else{
        if (md5($pass) == $u->clave){
                setcookie("usuario_id",$u->id,time()+3600,"/");
                setcookie("usuario_nombre",$u->nombre,time()+3600,"/");
                setcookie("usuario_apellidos",$u->apellidos,time()+3600,"/");
                setcookie("usuario_dni",$u->dni,time()+3600,"/");
                header("Location:inicio_cliente.php");
            }else{
                $error_pass="La contraseña es incorrecta";
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
</head>
<body>
    <h1>Iniciar Sesión</h1>
    
    <form action="" method="POST">
        dni: <input type="dni" name="dni" required><br>
        <?php if(isset($error_dni)) echo "<span style='color:red;'>$error_dni</span><br>"; ?>
        Contraseña: <input type="password" name="pass" required><br>
        <?php if(isset($error_pass)) echo "<span style='color:red;'>$error_pass</span><br>"; ?>
        <input type="submit" name="entrar" value="Entrar"><br>
    </form>
    
    <!-- <p><a href="registro.php">¿No tienes cuenta? Regístrate</a></p> -->
</body>
</html>
