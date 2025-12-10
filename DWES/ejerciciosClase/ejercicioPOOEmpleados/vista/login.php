<?php

require_once '../controlador/EmpleadoController.php';

if (isset($_POST['login'])) {
    $empleado = EmpleadoController::verificarEmpleado($_POST['email'], $_POST['pass']);
    if ($empleado != null) {
        session_name("emp");
        session_start();
        $_SESSION['emp'] = $empleado;
        header("Location: inicio.php");
        exit();
    } else {
        $error = "Contraseña y/o email incorrectos";
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login - Gestión de Tareas</title>
</head>
<body>
    <h2>Iniciar Sesión</h2>
    <?php if (isset($error)): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>
    
    <form action="" method="post">
        <label>Email:</label>
        <input type="text" name="email" required><br>
        
        <label>Contraseña:</label>
        <input type="password" name="pass" required><br>
        
        <input type="submit" name="login" value="Login">
    </form>
</body>
</html>
