<?php
require_once 'funciones.php';
$errores = [];
$nombre = $apellidos = $direccion = $localidad = $user = "";
$color_letra = $color_fondo = $tipo_letra = $tam_letra = "";

if(isset($_POST["registrar"])){
    // recogemos los valores de los formularios
    $nombre = trim($_POST['nombre']);
    $apellidos = trim($_POST['apellidos']);
    $direccion = trim($_POST['direccion']);
    $localidad = trim($_POST['localidad']);
    $user = trim($_POST['user']);
    $pass = $_POST['pass'];
    $pass_confirm = $_POST['pass_confirm'];
    $color_letra = $_POST['color_letra'];
    $color_fondo = $_POST['color_fondo'];
    $tipo_letra = $_POST['tipo_letra'];
    $tam_letra = $_POST['tam_letra'];

    // validamos los datos recogidos
    if(empty($nombre)){
        $errores[] = "El nombre no puede estar vacío";
    }
    
    if(empty($apellidos)){
        $errores[] = "Los apellidos no pueden estar vacíos";
    }
    
    if(empty($direccion)){
        $errores[] = "La dirección no puede estar vacía";
    }
    
    if(empty($localidad)){
        $errores[] = "La localidad no puede estar vacía";
    }
    
    if(empty($user)){
        $errores[] = "El email no puede estar vacío";
    }
    
    if(strlen($pass) < 6){
        $errores[] = "La contraseña debe tener al menos 6 caracteres";
    }
    
    if($pass != $pass_confirm){
        $errores[] = "Las contraseñas no coinciden";
    }
    
    // Verificar si el usuario ya existe
    if(empty($errores) && existeUsuario($user)){
        $errores[] = "El email ya está registrado";
    }
    
    // Si no hay errores, registrar
    if(empty($errores)){
        if(registrarUsuario($nombre, $apellidos, $direccion, $localidad, $user, $pass, $color_letra, $color_fondo, $tipo_letra, $tam_letra)){
            echo "<p style='color: green;'>Usuario registrado correctamente. <a href='login.php'>Ir al login</a></p>";
            $nombre = $apellidos = $direccion = $localidad = $user = "";
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
    <!-- Mostramos los errores enfatizaos antes de formulario con un echo -->
    <?php
        if(!empty($errores)){
            echo "<div style='color:red;'>";
            echo "<ul>";
            foreach($errores as $error){
                echo "<li>$error</li>";
            }
            echo "</ul>";
            echo "</div>";
        }
    ?>
    <form action="" method="post">
        Nombre <input type="text" name="nombre" value="<?php echo $nombre;?>" required><br><br>
                Apellidos: <input type="text" name="apellidos" value="<?php echo $apellidos; ?>" required><br><br>
        
        Dirección: <input type="text" name="direccion" value="<?php echo $direccion; ?>" required><br><br>
        
        Localidad: <input type="text" name="localidad" value="<?php echo $localidad; ?>" required><br><br>
        
        Email: <input type="text" name="user" value="<?php echo $user; ?>" required><br><br>
        
        Contraseña: <input type="password" name="pass" required><br><br>
        
        Confirmar contraseña: <input type="password" name="pass_confirm" required><br><br>
        
        Color de letra: 
        <select name="color_letra" required>
            <option value="black" <?php if($color_letra == "black") echo "selected"; ?>>Negro</option>
            <option value="blue" <?php if($color_letra == "blue") echo "selected"; ?>>Azul</option>
            <option value="red" <?php if($color_letra == "red") echo "selected"; ?>>Rojo</option>
            <option value="green" <?php if($color_letra == "green") echo "selected"; ?>>Verde</option>
        </select><br><br>
        
        Color de fondo: 
        <select name="color_fondo" required>
            <option value="white" <?php if($color_fondo == "white") echo "selected"; ?>>Blanco</option>
            <option value="lightgray" <?php if($color_fondo == "lightgray") echo "selected"; ?>>Gris claro</option>
            <option value="lightblue" <?php if($color_fondo == "lightblue") echo "selected"; ?>>Azul claro</option>
            <option value="lightyellow" <?php if($color_fondo == "lightyellow") echo "selected"; ?>>Amarillo claro</option>
            <option value="green" <?php if($color_fondo == "green") echo "selected"; ?>>Verde</option>
            <option value="red" <?php if($color_fondo == "red") echo "selected"; ?>>Rojo</option>
        </select><br><br>
        
        Tipo de letra: 
        <select name="tipo_letra" required>
            <option value="Arial" <?php if($tipo_letra == "Arial") echo "selected"; ?>>Arial</option>
            <option value="Verdana" <?php if($tipo_letra == "Verdana") echo "selected"; ?>>Verdana</option>
            <option value="Times New Roman" <?php if($tipo_letra == "Times New Roman") echo "selected"; ?>>Times New Roman</option>
            <option value="Courier New" <?php if($tipo_letra == "Courier New") echo "selected"; ?>>Courier New</option>
        </select><br><br>
        
        Tamaño de letra: 
        <select name="tam_letra" required>
            <option value="12" <?php if($tam_letra == "12") echo "selected"; ?>>12px</option>
            <option value="14" <?php if($tam_letra == "14") echo "selected"; ?>>14px</option>
            <option value="16" <?php if($tam_letra == "16") echo "selected"; ?>>16px</option>
            <option value="18" <?php if($tam_letra == "18") echo "selected"; ?>>18px</option>
            <option value="20" <?php if($tam_letra == "20") echo "selected"; ?>>20px</option>
            <option value="30" <?php if($tam_letra == "30") echo "selected"; ?>>30px</option>
        </select><br><br>
        
        <input type="submit" name="registrar" value="Registrar">
    </form>
    <br>
    <p><a href="login.php">Iniciar Sesio</a></p>
</body>
</html>