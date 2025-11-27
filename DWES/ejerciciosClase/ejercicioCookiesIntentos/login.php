<?php
session_start();
require_once 'funciones.php';

// Inicializar intentos si no existe
if(!isset($_SESSION["intentos"])){
    $_SESSION["intentos"] = 0;
}

$error_login = "";
$bloqueado = false;

// Verificar si está bloqueado (3 intentos fallidos)
if($_SESSION["intentos"] >= 3){
    $bloqueado = true;
    $error_login = "Has superado el número máximo de intentos. Cierra el navegador para volver a intentarlo.";
}

if(isset($_POST["entrar"]) && !$bloqueado){
    $email = trim($_POST["email"]);
    $pass = $_POST["pass"];
    
    $usuario = existeUsuario($email);
    
    if(!$usuario){
        $_SESSION["intentos"]++;
        $error_login = "El usuario no existe. Intentos restantes: " . (3 - $_SESSION["intentos"]);
    }else{
        if(password_verify($pass, $usuario->pass)){
            // Login exitoso
            $_SESSION["intentos"] = 0;
            
            // Guardar último acceso en cookie (antes de actualizarlo)
            if($usuario->ultimo_acceso){
                setcookie("ultimo_acceso", $usuario->ultimo_acceso, time() + (86400 * 30), "/");
            }
            
            // Guardar datos en cookies
            setcookie("dni", $usuario->DNI, time() + (86400 * 30), "/");
            setcookie("nombre", $usuario->Nombre, time() + (86400 * 30), "/");
            setcookie("apellidos", $usuario->Apellidos, time() + (86400 * 30), "/");
            setcookie("email", $usuario->email, time() + (86400 * 30), "/");
            
            // Actualizar último acceso en BD
            actualizarUltimoAcceso($email);
            
            // Guardar en sesión también
            $_SESSION["logueado"] = true;
            $_SESSION["email"] = $usuario->email;
            
            header("Location: index.php");
            exit();
        }else{
            $_SESSION["intentos"]++;
            $error_login = "Contraseña incorrecta. Intentos restantes: " . (3 - $_SESSION["intentos"]);
            
            if($_SESSION["intentos"] >= 3){
                $error_login = "Has superado el número máximo de intentos. Cierra el navegador para volver a intentarlo.";
                $bloqueado = true;
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
    
    <form action="" method="POST">
        Email: <input type="email" name="email" required <?php if($bloqueado) echo "disabled"; ?>><br><br>
        
        Contraseña: <input type="password" name="pass" required <?php if($bloqueado) echo "disabled"; ?>><br><br>
        
        <input type="submit" name="entrar" value="Entrar" <?php if($bloqueado) echo "disabled"; ?>>
    </form>
    
    <?php if($error_login) echo "<p style='color: red;'>$error_login</p>"; ?>
    
    <br>
    <p><a href="registro.php">Regístrate aquí</a></p>
</body>
</html>