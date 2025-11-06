<!-- Los datos a almacenar en el fichero para cada jugador son:
• Nombre del jugador (Campo de texto). No puede estar vacío. Sólo letras.
• DNI (Campo de texto). Debe tener 8 números y una letra al final.
• Dorsal. Campo desplegable con los números 1 al 11.
• Posición. Campo múltiple (Portero, defensa, centrocampista, delantero). Puede tener varias.
• Equipo (Campo de texto). No puede estar vacío.
• Número de goles (Campo de texto). No puede estar vacio. Sólo números. -->
<?php
require_once 'funciones.php';

$nombre = $dni = $equipo = $goles = "";
$dorsal = 1;
$posiciones_seleccionadas = [];
$errores = [];

if(isset($_POST['enviar'])){
    
    $nombre = trim($_POST['nombre']);
    $dni = strtoupper(trim($_POST['dni']));
    $dorsal = $_POST['dorsal'];
    $posiciones_seleccionadas = isset($_POST['posicion']) ? $_POST['posicion'] : [];
    $equipo = trim($_POST['equipo']);
    $goles = $_POST['goles'];
    
    // Validar nombre (solo letras)
    if(empty($nombre) || !preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $nombre)){
        $errores[] = "El nombre solo puede contener letras.";
    }
    
    // Validar DNI
    $regex = '/^[0-9]{8}[TRWAGMYFPDXBNJZSQVHLCKE]$/i';
    if(!preg_match($regex, $dni)){
        $errores[] = "El DNI debe tener 8 números y una letra (ej: 12345678A).";
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
    
    // Si no hay errores, insertar
    if(empty($errores)){
        addJugador($nombre, $dni, $dorsal, $posiciones_seleccionadas, $equipo, $goles);
        // Limpiar formulario
        $nombre = $dni = $equipo = $goles = "";
        $dorsal = 1;
        $posiciones_seleccionadas = [];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Jugador</title>
</head>
<body>
    <h1>INTRODUCIR JUGADOR</h1>
    
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
    
    <form action="" method="post">
        Nombre: <input type="text" name="nombre" value="<?php echo $nombre; ?>" required><br><br>
        
        DNI: <input type="text" name="dni" value="<?php echo $dni; ?>" placeholder="12345678A" required><br><br>
        
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

        <input type="submit" name="enviar" value="Enviar">
        <a href="index.php">Volver al menú</a>
    </form>
</body>
</html>