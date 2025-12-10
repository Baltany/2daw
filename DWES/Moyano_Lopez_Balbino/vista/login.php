<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h1>LOGIN</h1>
    
    <?php
    if(isset($_GET['mensaje'])){
        echo "<p style='color: red;'>" . $_GET['mensaje'] . "</p>";
    }
    
    if(isset($error)){
        echo "<p style='color: red;'>$error</p>";
    }
    ?>
    
    <form action="" method="POST">
        DNI: <input type="text" name="dni" required><br><br>
        Clave: <input type="password" name="clave" required><br><br>
        <input type="submit" name="login" value="Entrar">
    </form>
    
    <br>
    <a href="index.php">Volver a inicio</a>
</body>
</html>