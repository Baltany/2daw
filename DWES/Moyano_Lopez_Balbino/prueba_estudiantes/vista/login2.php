<?php
session_start();
if(isset($_SESSION['usuario'])){
    header("Location: menu.php");
    exit();
}

require_once '../model/Profesor.php';
require_once '../controller/ProfesorController2.php';

if(isset($_POST['entrar'])){
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];

    if(empty($usuario)){
        $error = "El usuario es obligatorio";
    }else{
        $u = ProfesorController2::buscarPorUsuario($usuario);
        
        if(!$u){
            $error = "El usuario no existe";
        }else{
            if(ProfesorController2::estaBloqueado($usuario)){
                $error = "Usuario bloqueado. Has superado los 3 intentos permitidos.";
            }else{
                if(password_verify($clave, $u->clave)){
                    ProfesorController2::resetearIntentos($usuario);
                    $_SESSION['usuario'] = serialize($u);
                    header("Location: menu.php");
                    exit();
                }else{
                    $intentos = ProfesorController2::registrarIntentoFallido($usuario);
                    
                    if($intentos >= 3){
                        $error = "Usuario bloqueado. Has superado los 3 intentos permitidos.";
                    }else{
                        $intentos_restantes = 3 - $intentos;
                        $error = "Contraseña incorrecta. Te quedan $intentos_restantes intento(s).";
                    }
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <h2>Inicio de Sesión</h2>

    <form action="" method="post">
        <?php if(isset($error)): ?>
        <p><strong><?php echo $error; ?></strong></p>
        <?php endif; ?>

        Usuario: <input type="text" name="usuario" required><br><br>
        Contraseña: <input type="password" name="clave" required><br><br>
        <input type="submit" name="entrar" value="Entrar">
    </form>
</body>

</html>