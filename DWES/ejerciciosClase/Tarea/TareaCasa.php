<?php
// Inicializar array de donde se muestran los errores
$errores = array();

// Validar si se envió el formulario
if(isset($_POST['enviar'])){
    if(empty($_POST['nombre'])){
        $errores[] = 'nombre';
    }
    if(empty($_POST['apell'])){
        $errores[] = 'apell';
    }
    if(empty($_POST['modulos'])){
        $errores[] = 'modulos';
    }
}

// Si no hay errores, mostrar los datos
if(isset($_POST['enviar']) && empty($errores)){
    echo "<h3>Datos recibidos:</h3>";
    echo "Nombre: " . $_POST['nombre'] . "<br>";
    echo "Apellidos: " . $_POST['apell'] . "<br>";
    echo "Módulos seleccionados:<br>";
    foreach($_POST['modulos'] as $modulo){
        echo "- " . $modulo . "<br>";
    }
    echo "<br><a href=''>Volver al formulario</a>";
} else {
    // Mostramos el formulario
?>

<form action="" method="post">
    Nombre: 
    <input type="text" name="nombre" value="<?php if(isset($_POST['nombre']) && !in_array('nombre', $errores)) echo $_POST['nombre']; ?>">
    <?php if(isset($_POST['enviar']) && in_array('nombre', $errores)) echo '<span style="color:red"> El nombre está vacío </span>'; ?>
    <br><br>
    
    Apellidos: 
    <input type="text" name="apell" value="<?php if(isset($_POST['apell']) && !in_array('apell', $errores)) echo $_POST['apell']; ?>">
    <?php if(isset($_POST['enviar']) && in_array('apell', $errores)) echo '<span style="color:red"> El apellido está vacío </span>'; ?>
    <br><br>
    
    Módulos:
    <?php if(isset($_POST['enviar']) && in_array('modulos', $errores)) echo '<span style="color:red"> Los módulos están vacíos </span>'; ?>
    <br>
    
    <input type="checkbox" name="modulos[]" value="DWES" 
        <?php if(isset($_POST['modulos']) && in_array('DWES', $_POST['modulos'])) echo 'checked'; ?>>
    Desarrollo web entorno servidor <br>
    
    <input type="checkbox" name="modulos[]" value="DWEC" 
        <?php if(isset($_POST['modulos']) && in_array('DWEC', $_POST['modulos'])) echo 'checked'; ?>>
    Desarrollo web entorno cliente<br>
    
    <input type="checkbox" name="modulos[]" value="DIW" 
        <?php if(isset($_POST['modulos']) && in_array('DIW', $_POST['modulos'])) echo 'checked'; ?>>
    Desarrollo interfaces web <br><br>
    
    <input type="submit" name="enviar" value="Enviar">
</form>

<?php
}
?>