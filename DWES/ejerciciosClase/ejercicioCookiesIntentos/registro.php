<?php
require_once 'funciones.php';
//definimos errores como vacio y las variables como ""
$errores=[];
$dni=$nombre=$apellidos=$email="";
// definimos patron de email
$patron_email = "/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";

// validamos datos obtenidos del registro
if(isset($_POST["registrar"])){
    $dni = trim($_POST["dni"]);
    $nombre = trim($_POST["nombre"]);
    $apellidos = trim($_POST["apellidos"]);
    $email = trim($_POST["email"]);
    $pass = $_POST["pass"];
    $pass_confirm = $_POST["pass_confirm"];
    
    // Validaciones
    if(empty($dni)){
        $errores[] = "El DNI no puede estar vacio";
    }
    
    if(empty($nombre)){
        $errores[] = "El nombre no puede estar vacio";
    }
    
    if(empty($apellidos)){
        $errores[] = "Los apellidos no pueden estar vacios";
    }
    
    if(empty($email) || !preg_match($patron_email, $email)){
        $errores[] = "El email no es válido";
    }
    
    // si la longitud es menos de 6 no lo cogemos la password
    if(strlen($pass) < 6){
        $errores[] = "La contraseña debe tener al menos 6 caracteres";
    }
    
    if($pass != $pass_confirm){
        $errores[] = "Las contraseñas no coinciden";
    }
    
    // Verificar si el email ya existe
    if(empty($errores) && existeUsuario($email)){
        $errores[] = "El email ya está registrado";
    }
    
    // Si no hay errores, registrar
    if(empty($errores)){
        if(registrarUsuario($dni, $nombre, $apellidos, $email, $pass)){
            echo "<p style='color: green;'>Usuario registrado correctamente. <a href='login.php'>Ir al login</a></p>";
            $dni = $nombre = $apellidos = $email = "";
        }else{
            $errores[] = "Error al registrar el usuario";
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>
<body>
    <?php
    if(!empty($errores)){
        // le damos enfasis con el color rojo
        echo "<div style='color: red;'>";
        echo "<h3>Errores:</h3>";
        echo "<ul>";
        foreach($errores as $error){
            echo "<li>$error</li>";
        }
        echo "</ul>";
        echo "</div>";
    }
    ?>
    
    <form action="" method="POST">
        DNI: <input type="text" name="dni" value="<?php echo $dni; ?>" required><br><br>
        
        Nombre: <input type="text" name="nombre" value="<?php echo $nombre; ?>" required><br><br>
        
        Apellidos: <input type="text" name="apellidos" value="<?php echo $apellidos; ?>" required><br><br>
        
        Email: <input type="email" name="email" value="<?php echo $email; ?>" required><br><br>
        
        Contraseña: <input type="password" name="pass" required><br><br>
        
        Confirmar contraseña: <input type="password" name="pass_confirm" required><br><br>
        
        <input type="submit" name="registrar" value="Registrar">
    </form>
    
    <br>
    <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a></p>
</body>

</html>