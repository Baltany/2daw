<?php
session_start();
if(isset($_SESSION['usuario'])){
    header("Location: menu.php");
    exit();
}

require_once '../model/Usuario.php';
require_once '../controller/UsuarioController.php';

if(isset($_POST['entrar'])){
    $email = $_POST['email'];
    $clave = $_POST['clave'];

    if(empty($email)){
        $error_codigo = "El email es obligatorio";
    }else{
        $u = UsuarioController::buscarPorEmail($email);
        if(!$u){
            $error_codigo = "El usuario no existe";
        }else{
            // if(md5($clave) == $usuario->clave)
            if(password_verify($clave,$u->clave)){
                $_SESSION['usuario'] = serialize($u);
                header("Location: menu.php");
                exit();
            }else
            { 
                $error_pass = "La contraseña es incorrecta";
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
    <title>Login - Balbino</title>
</head>

<body>
    <form action="" method="post">
        Email: <input type="text" name="email" required><br>
        <?php if(isset($error_codigo)) echo "<span style='color:red;'>$error_codigo</span><br>"; ?>

        Contraseña <input type="password" placeholder="123456" name="clave" required><br>
        <?php if(isset($error_pass)) echo "<span style='color:red;'>$error_pass</span><br>"; ?>

        <input type="submit" name="entrar" value="Entrar"><br>
    </form>
</body>

</html>