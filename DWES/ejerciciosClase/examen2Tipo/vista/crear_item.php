<?php
session_start();
if(!isset($_COOKIE['usuario_id'])){
    header("Location:login.php");
}

require_once '../model/Item.php';
require_once '../controller/ItemController.php';

if(isset($_POST['crear'])){
    $errores=array();
    
    $nombre=trim($_POST['nombre']);
    $apellidos=trim($_POST['apellidos']);
    $provincia=$_POST['provincia'];
    $sexo=isset($_POST['sexo']) ? $_POST['sexo'] : '';
    $edad=isset($_POST['edad']) ? $_POST['edad'] : '';
    $estado_civil=$_POST['estado_civil'];
    $aficiones=isset($_POST['aficiones']) ? implode(', ',$_POST['aficiones']) : '';
    $estudios=isset($_POST['estudios']) ? implode(', ',$_POST['estudios']) : '';
    
    if(empty($nombre)){
        $errores[]="El nombre es obligatorio";
    }
    
    if(empty($apellidos)){
        $errores[]="Los apellidos son obligatorios";
    }
    
    if(empty($provincia)){
        $errores[]="Debes seleccionar una provincia";
    }
    
    if(empty($errores)){
        $i=new Item(0,$nombre,$apellidos,$provincia,$sexo,$edad,$estado_civil,$aficiones,$estudios);
        
        if(itemController::insertar($i)){
            echo "<br>Item creado correctamente<br>";
            echo "<a href='items.php'>Ver todos los items</a>";
        }else{
            $errores[]="Error al crear el item";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Item</title>
</head>
<body>
    <h1>Crear Nuevo Item</h1>
    
    <a href="items.php">Volver a Items</a>
    
    <hr>
    
    <?php if(isset($errores) && !empty($errores)): ?>
        <div style="color:red;">
            <h3>Errores:</h3>
            <ul>
                <?php foreach($errores as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <form method="POST" action="">
        Nombre: <input type="text" name="nombre" required 
               value="<?php echo isset($_POST['nombre']) ? $_POST['nombre'] : ''; ?>"><br><br>
        
        Apellidos: <input type="text" name="apellidos" required 
               value="<?php echo isset($_POST['apellidos']) ? $_POST['apellidos'] : ''; ?>"><br><br>
        
        Provincia: <select name="provincia" required>
            <option value="">Seleccione una provincia</option>
            <option value="Malaga" <?php echo (isset($_POST['provincia']) && $_POST['provincia'] == 'Malaga') ? 'selected' : ''; ?>>Málaga</option>
            <option value="Cordoba" <?php echo (isset($_POST['provincia']) && $_POST['provincia'] == 'Cordoba') ? 'selected' : ''; ?>>Córdoba</option>
            <option value="Jaen" <?php echo (isset($_POST['provincia']) && $_POST['provincia'] == 'Jaen') ? 'selected' : ''; ?>>Jaén</option>
            <option value="Almeria" <?php echo (isset($_POST['provincia']) && $_POST['provincia'] == 'Almeria') ? 'selected' : ''; ?>>Almería</option>
            <option value="Sevilla" <?php echo (isset($_POST['provincia']) && $_POST['provincia'] == 'Sevilla') ? 'selected' : ''; ?>>Sevilla</option>
            <option value="Granada" <?php echo (isset($_POST['provincia']) && $_POST['provincia'] == 'Granada') ? 'selected' : ''; ?>>Granada</option>
            <option value="Cadiz" <?php echo (isset($_POST['provincia']) && $_POST['provincia'] == 'Cadiz') ? 'selected' : ''; ?>>Cádiz</option>
            <option value="Huelva" <?php echo (isset($_POST['provincia']) && $_POST['provincia'] == 'Huelva') ? 'selected' : ''; ?>>Huelva</option>
        </select><br><br>
        
        Sexo: 
        <input type="radio" name="sexo" value="Hombre" <?php echo (isset($_POST['sexo']) && $_POST['sexo'] == 'Hombre') ? 'checked' : ''; ?>> Hombre
        <input type="radio" name="sexo" value="Mujer" <?php echo (isset($_POST['sexo']) && $_POST['sexo'] == 'Mujer') ? 'checked' : ''; ?>> Mujer
        <input type="radio" name="sexo" value="Otro" <?php echo (isset($_POST['sexo']) && $_POST['sexo'] == 'Otro') ? 'checked' : ''; ?>> Otro<br><br>
        
        Edad: <input type="text" name="edad" 
               value="<?php echo isset($_POST['edad']) ? $_POST['edad'] : ''; ?>"><br><br>
        
        Estado Civil: <select name="estado_civil">
            <option value="">Seleccione</option>
            <option value="Soltero" <?php echo (isset($_POST['estado_civil']) && $_POST['estado_civil'] == 'Soltero') ? 'selected' : ''; ?>>Soltero/a</option>
            <option value="Casado" <?php echo (isset($_POST['estado_civil']) && $_POST['estado_civil'] == 'Casado') ? 'selected' : ''; ?>>Casado/a</option>
            <option value="Divorciado" <?php echo (isset($_POST['estado_civil']) && $_POST['estado_civil'] == 'Divorciado') ? 'selected' : ''; ?>>Divorciado/a</option>
            <option value="Viudo" <?php echo (isset($_POST['estado_civil']) && $_POST['estado_civil'] == 'Viudo') ? 'selected' : ''; ?>>Viudo/a</option>
        </select><br><br>
        
        Aficiones:<br>
        <input type="checkbox" name="aficiones[]" value="Cine" <?php echo (isset($_POST['aficiones']) && in_array('Cine', $_POST['aficiones'])) ? 'checked' : ''; ?>> Cine
        <input type="checkbox" name="aficiones[]" value="Deporte" <?php echo (isset($_POST['aficiones']) && in_array('Deporte', $_POST['aficiones'])) ? 'checked' : ''; ?>> Deporte
        <input type="checkbox" name="aficiones[]" value="Lectura" <?php echo (isset($_POST['aficiones']) && in_array('Lectura', $_POST['aficiones'])) ? 'checked' : ''; ?>> Lectura
        <input type="checkbox" name="aficiones[]" value="Musica" <?php echo (isset($_POST['aficiones']) && in_array('Musica', $_POST['aficiones'])) ? 'checked' : ''; ?>> Música
        <input type="checkbox" name="aficiones[]" value="TV" <?php echo (isset($_POST['aficiones']) && in_array('TV', $_POST['aficiones'])) ? 'checked' : ''; ?>> TV
        <input type="checkbox" name="aficiones[]" value="Viajar" <?php echo (isset($_POST['aficiones']) && in_array('Viajar', $_POST['aficiones'])) ? 'checked' : ''; ?>> Viajar<br><br>
        
        Estudios:<br>
        <select name="estudios[]" multiple size="8">
            <option value="ESO" <?php echo (isset($_POST['estudios']) && in_array('ESO', $_POST['estudios'])) ? 'selected' : ''; ?>>ESO</option>
            <option value="Bachillerato" <?php echo (isset($_POST['estudios']) && in_array('Bachillerato', $_POST['estudios'])) ? 'selected' : ''; ?>>Bachillerato</option>
            <option value="CFGM" <?php echo (isset($_POST['estudios']) && in_array('CFGM', $_POST['estudios'])) ? 'selected' : ''; ?>>CFGM</option>
            <option value="CFGS" <?php echo (isset($_POST['estudios']) && in_array('CFGS', $_POST['estudios'])) ? 'selected' : ''; ?>>CFGS</option>
            <option value="Universidad" <?php echo (isset($_POST['estudios']) && in_array('Universidad', $_POST['estudios'])) ? 'selected' : ''; ?>>Universidad</option>
            <option value="Postgrado" <?php echo (isset($_POST['estudios']) && in_array('Postgrado', $_POST['estudios'])) ? 'selected' : ''; ?>>Postgrado</option>
            <option value="Master" <?php echo (isset($_POST['estudios']) && in_array('Master', $_POST['estudios'])) ? 'selected' : ''; ?>>Máster</option>
            <option value="Doctorado" <?php echo (isset($_POST['estudios']) && in_array('Doctorado', $_POST['estudios'])) ? 'selected' : ''; ?>>Doctorado</option>
        </select><br><br>
        
        <input type="submit" name="crear" value="Crear Item">
    </form>
</body>
</html>
