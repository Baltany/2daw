<?php
session_start();

// Si ya está logueado, redirigir
if(isset($_SESSION['empleado'])){
    header("Location: menu.php");
    exit();
}

require_once '../model/Empleado.php';
require_once '../controller/EmpleadoController.php';

if(isset($_POST['entrar'])){
    $codigo = $_POST['codigo'];
    $pass = $_POST['clave'];
    
    if(empty($codigo)){
        $error_codigo = "El código es obligatorio";
    }else{
        $u = EmpleadoController::buscarPorCodigo($codigo);
        if(!$u){
            $error_codigo = "El empleado no existe";
        }else{
            // CORRECCIÓN: usar password_verify en lugar de password_hash
            if(password_verify($pass, $u->clave)){
                // CORRECCIÓN: Usar SESIONES en lugar de cookies
                $_SESSION['empleado'] = serialize($u);
                header("Location: menu.php");
                exit();
            }else{
                $error_pass = "La contraseña es incorrecta";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h1>Iniciar Sesión - Taller Mecánico</h1>

    <form action="" method="POST">
        Código: <input type="text" name="codigo" required><br>
        <?php if(isset($error_codigo)) echo "<span style='color:red;'>$error_codigo</span><br>"; ?>
        
        Contraseña: <input type="password" name="clave" required><br>
        <?php if(isset($error_pass)) echo "<span style='color:red;'>$error_pass</span><br>"; ?>
        
        <input type="submit" name="entrar" value="Entrar"><br>
    </form>
</body>
</html>