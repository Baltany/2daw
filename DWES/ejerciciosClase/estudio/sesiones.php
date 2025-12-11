<?php
// login.php
session_start();
require_once 'modelos/Usuario.php';

if(isset($_POST['login'])){
    $email = trim($_POST['email']);
    $pass = $_POST['pass'];
    
    $usuario = Usuario::login($email, $pass);
    
    if($usuario){
        // Guardar en sesión (serialize para objetos)
        $_SESSION['usuario'] = serialize($usuario);
        
        // También se puede guardar sin serialize
        // $_SESSION['id'] = $usuario->id;
        // $_SESSION['nombre'] = $usuario->nombre;
        
        header("Location: index.php");
        exit();
    }else{
        $error = "Email o contraseña incorrectos";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h1>LOGIN</h1>
    
    <form action="" method="POST">
        Email: <input type="text" name="email" required><br><br>
        Pass: <input type="password" name="pass" required><br><br>
        <input type="submit" name="login" value="Entrar">
    </form>
    
    <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
</body>
</html>