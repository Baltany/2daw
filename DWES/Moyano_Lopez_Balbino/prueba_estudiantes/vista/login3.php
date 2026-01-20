<?php
session_start();
if(isset($_SESSION['usuario'])){
    header("Location: menu.php");
    exit();
}

// Verificar si existe cookie de recordar
if(isset($_COOKIE['recordar_usuario']) && !isset($_SESSION['usuario'])){
    require_once '../model/Profesor.php';
    require_once '../controller/ProfesorController3.php';
    
    $usuario_cookie = $_COOKIE['recordar_usuario'];
    $u = ProfesorController3::buscarPorUsuario($usuario_cookie);
    
    if($u){
        $_SESSION['usuario'] = serialize($u);
        header("Location: menu.php");
        exit();
    }
}

require_once '../model/Profesor.php';
require_once '../controller/ProfesorController3.php';

if(isset($_POST['entrar'])){
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];
    $recordar = isset($_POST['recordar']);

    if(empty($usuario)){
        $error = "El usuario es obligatorio";
    }else{
        $u = ProfesorController3::buscarPorUsuario($usuario);
        
        if(!$u){
            $error = "El usuario no existe";
        }else{
            if(password_verify($clave, $u->clave)){
                $_SESSION['usuario'] = serialize($u);
                
                // Si marcó "Recuérdame", crear cookie por 30 días
                if($recordar){
                    setcookie('recordar_usuario', $usuario, time() + (30 * 24 * 60 * 60), '/');
                }else{
                    // Si no marcó recordar, eliminar cookie si existe
                    if(isset($_COOKIE['recordar_usuario'])){
                        setcookie('recordar_usuario', '', time() - 3600, '/');
                    }
                }
                
                header("Location: menu.php");
                exit();
            }else{
                $error = "Contraseña incorrecta.";
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

        <input type="checkbox" name="recordar" id="recordar">
        <label for="recordar">Recuérdame</label><br><br>

        <input type="submit" name="entrar" value="Entrar">
    </form>
</body>

</html>