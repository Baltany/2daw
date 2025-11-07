<?php
require_once 'funciones.php';

$jugador = null;
$nombre = $dni_buscar = $equipo = $goles = "";
$dorsal = 1;
$posiciones_seleccionadas = [];
$errores = [];
$mostrar_formulario = false;

// Buscar jugador por DNI
if(isset($_POST['buscar_dni'])){
    $dni_buscar = strtoupper(trim($_POST['dni_buscar']));
    $jugador = existeJugador($dni_buscar);
    
    if($jugador){
        $mostrar_formulario = true;
        $nombre = $jugador->nombre;
        $dorsal = $jugador->dorsal;
        $posiciones_seleccionadas = explode(',', $jugador->posicion);
        $equipo = $jugador->equipo;
        $goles = $jugador->goles;
    }else{
        $errores[] = "El DNI introducido no existe en la base de datos.";
    }
}

// Modificar jugador
if(isset($_POST['modificar'])){
    $dni_buscar = strtoupper(trim($_POST['dni_original']));
    $nombre = trim($_POST['nombre']);
    $dorsal = $_POST['dorsal'];
    $posiciones_seleccionadas = isset($_POST['posicion']) ? $_POST['posicion'] : [];
    $equipo = trim($_POST['equipo']);
    $goles = $_POST['goles'];
    
    $mostrar_formulario = true;
    
    // Validar nombre
    if(empty($nombre) || !preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $nombre)){
        $errores[] = "El nombre solo puede contener letras.";
    }
    
    // Validar posición
    if(empty($posiciones_seleccionadas)){
        $errores[] = "Debe seleccionar al menos una posición.";
    }
    
    // Validar equipo
    if(empty($equipo)){
        $errores[] = "El equipo no puede estar vacío.";
    }
    
    // Validar goles
    if(empty($goles) || !is_numeric($goles) || $goles < 0){
        $errores[] = "Los goles deben ser un número válido.";
    }
    
    // Si no hay errores, modificar
    if(empty($errores)){
        if(modificarJugador($dni_buscar, $nombre, $dorsal, $posiciones_seleccionadas, $equipo, $goles)){
            $mostrar_formulario = false;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Jugador</title>
</head>
<body>
    <h1>MODIFICAR JUGADOR</h1>
    
    <?php
    if(!empty($errores)){
        echo "<div style='color: red;'>";
        echo "<h3>Errores encontrados:</h3>";
        echo "<ul>";
        foreach($errores as $error){
            echo "<li>$error</li>";
        }
        echo "</ul>";
        echo "</div>";
    }
    ?>
    
    <?php if(!$mostrar_formulario): ?>
    <!-- Formulario para buscar por DNI -->
    <form action="" method="post">
        <h3>Buscar jugador por DNI:</h3>
        DNI: <input type="text" name="dni_buscar" placeholder="12345678A" required><br><br>
        <input type="submit" name="buscar_dni" value="Buscar">
    </form>
    
    <?php else: ?>
    <!-- Formulario de modificacion -->
    <form action="" method="post">
        <input type="hidden" name="dni_original" value="<?php echo $dni_buscar; ?>">
        
        <h3>Datos del jugador con DNI: <?php echo $dni_buscar; ?></h3>
        
        Nombre: <input type="text" name="nombre" value="<?php echo $nombre; ?>" required><br><br>
        
        Dorsal: 
        <select name="dorsal" required>
            <?php
            for($i = 1; $i <= 11; $i++){
                $selected = ($dorsal == $i) ? "selected" : "";
                echo "<option value='$i' $selected>$i</option>";
            }
            ?>
        </select><br><br>
        
        Posición (mantén Ctrl para seleccionar varias): <br>
        <select multiple name="posicion[]" size="4" required>
            <?php
            $posiciones = ['Portero', 'Defensa', 'Centrocampista', 'Delantero'];
            foreach($posiciones as $pos){
                $selected = in_array($pos, $posiciones_seleccionadas) ? "selected" : "";
                echo "<option value='$pos' $selected>$pos</option>";
            }
            ?>
        </select><br><br>
        
        Equipo: <input type="text" name="equipo" value="<?php echo $equipo; ?>" required><br><br>
        
        Nº goles: <input type="number" name="goles" value="<?php echo $goles; ?>" min="0" required><br><br>

        <input type="submit" name="modificar" value="Modificar">
        <a href="modificar.php"><button type="button">Cancelar</button></a>
    </form>
    <?php endif; ?>
    
    <br>
    <a href="index.php">Volver al menú</a>
</body>
</html>