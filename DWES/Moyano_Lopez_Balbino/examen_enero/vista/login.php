<?php
session_start();
if(isset($_SESSION['profesor'])){
    header("Location: partes.php");
    exit();
}

require_once '../model/Profesor.php';
require_once '../controller/ProfesorController.php';

if(isset($_POST['entrar'])){
    //dni_p
    $profesor = $_POST['profesor'];
    $pass = $_POST['pass'];

    if(empty($profesor)){
        $error = "El profesor es obligatorio";
    }else{
        $u = ProfesorController::buscarPorDni($profesor);
        
        if(!$u){
            $error = "El profesor no existe";
        }else{
            if(ProfesorController::estaBloqueado($profesor)){
                $error = "profesor bloqueado. Has superado los 3 intentos permitidos.";
            }else{
                $password_md5 = md5($pass);
                //echo md5($pass);
                if($password_md5 == $u->pass){

                    ProfesorController::resetearIntentos($profesor);
                    $_SESSION['profesor'] = serialize($u);
                    header("Location: partes.php");
                    exit();
                }else{
                    $intentos = ProfesorController::registrarIntentoFallido($profesor);
                    
                    if($intentos >= 3){
                        $error = "profesor bloqueado. Has superado los 3 intentos permitidos.";
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

        DNI: <input type="text" name="profesor" placeholder="12345678A" required><br><br>
        Contraseña: <input type="password" name="pass" required><br><br>
        <input type="submit" name="entrar" value="Entrar">
    </form>
</body>

</html>