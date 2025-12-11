<?php
session_start();
if(isset($_COOKIE['usuario_id'])){
    header("Location:index.php");
}
require_once '../model/Usuario.php';
require_once '../controller/UsuarioController.php';

if(isset($_POST['entrar'])){
    $email=$_POST['email'];
    $pass=$_POST['pass'];
    
    if(empty($email)){
        $error_email="El email es obligatorio";
    }else{
        $u=usuarioController::buscarPorEmail($email);
        if(!$u){
            $error_email="El usuario no existe";
        }else{
            if(password_verify($pass,$u->password)){
                setcookie("usuario_id",$u->id,time()+3600,"/");
                setcookie("usuario_nombre",$u->nombre,time()+3600,"/");
                setcookie("usuario_apellidos",$u->apellidos,time()+3600,"/");
                setcookie("usuario_dni",$u->dni,time()+3600,"/");
                header("Location:index.php");
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
        Email: <input type="email" name="email" required><br>
        <?php if(isset($error_email)) echo "<span style='color:red;'>$error_email</span><br>"; ?>
        Contraseña: <input type="password" name="pass" required><br>
        <?php if(isset($error_pass)) echo "<span style='color:red;'>$error_pass</span><br>"; ?>
        <input type="submit" name="entrar" value="Entrar"><br>
    </form>
    
    <p><a href="registro.php">¿No tienes cuenta? Regístrate</a></p>
</body>
</html>
