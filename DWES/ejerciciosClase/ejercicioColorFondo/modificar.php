<?php
session_start();
require_once 'funciones.php';

// protegemos la ruta sino esta logueao
if(!isset($_SESSION['logueado']) || !isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

// obtenemos los datos del usuario
$usuario = getUsuarioUser($_SESSION['user']);

$errores = [];
$mensaje = "";


if(isset($_POST['modificar'])){
    $nombre = trim($_POST["nombre"]);
    $apellidos = trim($_POST["apellidos"]);
    $direccion = trim($_POST["direccion"]);
    $localidad = trim($_POST["localidad"]);
    $color_letra = $_POST["color_letra"];
    $color_fondo = $_POST["color_fondo"];
    $tipo_letra = $_POST["tipo_letra"];
    $tam_letra = $_POST["tam_letra"];
    
    // Validaciones
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

    // Si no hay errores, se modifica los datos
    if(empty($errores)){
        if(modificarUsuario($nombre, $apellidos, $direccion, $localidad, $color_letra, $color_fondo, $tipo_letra, $tam_letra, $_SESSION["user"])){
            $mensaje = "<p style='color: green;'>Datos modificados correctamente</p>";
            
            // Actualizar sesión
            $_SESSION["nombre"] = $nombre;
            $_SESSION["apellidos"] = $apellidos;
            $_SESSION["tipo_letra"] = $tipo_letra;
            $_SESSION["color_letra"] = $color_letra;
            $_SESSION["color_fondo"] = $color_fondo;
            $_SESSION["tam_letra"] = $tam_letra;
            
            // Recargar usuario
            $usuario = getUsuarioUser($_SESSION["user"]);
        }else{
            $errores[] = "Error al modificar los datos";
        }
    }


}

$estilo = "font-family: " . $_SESSION["tipo_letra"] . "; 
           color: " . $_SESSION["color_letra"] . "; 
           background-color: " . $_SESSION["color_fondo"] . "; 
           font-size: " . $_SESSION["tam_letra"] . "px;";


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar</title>
</head>
<body style="<?php echo $estilo; ?>">
        <?php echo $mensaje; ?>
    
    <?php
    if(!empty($errores)){
        echo "<div style='color: red;'>";
        echo "<ul>";
        foreach($errores as $error){
            echo "<li>$error</li>";
        }
        echo "</ul>";
        echo "</div>";
    }
    ?>

        <form action="" method="POST">
        Nombre: <input type="text" name="nombre" value="<?php echo $usuario->nombre; ?>" required><br><br>
        
        Apellidos: <input type="text" name="apellidos" value="<?php echo $usuario->apellidos; ?>" required><br><br>
        
        Dirección: <input type="text" name="direccion" value="<?php echo $usuario->direccion; ?>" required><br><br>
        
        Localidad: <input type="text" name="localidad" value="<?php echo $usuario->localidad; ?>" required><br><br>
        
        Color de letra: 
        <select name="color_letra" required>
            <option value="black" <?php if($usuario->color_letra == "black") echo "selected"; ?>>Negro</option>
            <option value="blue" <?php if($usuario->color_letra == "blue") echo "selected"; ?>>Azul</option>
            <option value="red" <?php if($usuario->color_letra == "red") echo "selected"; ?>>Rojo</option>
            <option value="green" <?php if($usuario->color_letra == "green") echo "selected"; ?>>Verde</option>
        </select><br><br>
        
        Color de fondo: 
        <select name="color_fondo" required>
            <option value="white" <?php if($usuario->color_fondo == "white") echo "selected"; ?>>Blanco</option>
            <option value="lightgray" <?php if($usuario->color_fondo == "lightgray") echo "selected"; ?>>Gris claro</option>
            <option value="lightblue" <?php if($usuario->color_fondo == "lightblue") echo "selected"; ?>>Azul claro</option>
            <option value="lightyellow" <?php if($usuario->color_fondo == "lightyellow") echo "selected"; ?>>Amarillo claro</option>
            <option value="green" <?php if($usuario->color_fondo == "green") echo "selected"; ?>>Verde</option>
            <option value="red" <?php if($usuario->color_fondo == "red") echo "selected"; ?>>Rojo</option>
        </select><br><br>
        Tipo de letra: 
        <select name="tipo_letra" required>
            <option value="Arial" <?php if($usuario->tipo_letra == "Arial") echo "selected"; ?>>Arial</option>
            <option value="Verdana" <?php if($usuario->tipo_letra == "Verdana") echo "selected"; ?>>Verdana</option>
            <option value="Times New Roman" <?php if($usuario->tipo_letra == "Times New Roman") echo "selected"; ?>>Times New Roman</option>
            <option value="Courier New" <?php if($usuario->tipo_letra == "Courier New") echo "selected"; ?>>Courier New</option>
        </select><br><br>
        
        Tamaño de letra: 
        <select name="tam_letra" required>
            <option value="12" <?php if($usuario->tam_letra == "12") echo "selected"; ?>>12px</option>
            <option value="14" <?php if($usuario->tam_letra == "14") echo "selected"; ?>>14px</option>
            <option value="16" <?php if($usuario->tam_letra == "16") echo "selected"; ?>>16px</option>
            <option value="18" <?php if($usuario->tam_letra == "18") echo "selected"; ?>>18px</option>
            <option value="20" <?php if($usuario->tam_letra == "20") echo "selected"; ?>>20px</option>
            <option value="30" <?php if($usuario->tam_letra == "30") echo "selected"; ?>>30px</option>
        </select><br><br>
        
        <input type="submit" name="modificar" value="Modificar">
    </form>
    
    <br>
    <a href="inicio.php">Volver</a>


</body>
</html>