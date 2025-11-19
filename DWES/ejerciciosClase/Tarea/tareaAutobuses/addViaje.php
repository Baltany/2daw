<?php
require_once 'funciones.php';

$autobuses = getBus();

$mensaje = "";
$fecha = $matricula = $origen = $destino = $plazas_libres = "";
$errores = [];

if(isset($_POST['enviar'])){
    $fecha = $_POST['fecha'];
    $matricula = $_POST['matricula'];
    $origen = trim($_POST['origen']);
    $destino = trim($_POST['destino']);
    $plazas_libres = $_POST['plazas_libres'];
    
    // Validaciones
    if(empty($fecha)){
        $errores[] = "La fecha no puede estar vacía.";
    }
    
    if(empty($matricula)){
        $errores[] = "Debe seleccionar un autobús.";
    }
    
    if(empty($origen)){
        $errores[] = "El origen no puede estar vacío.";
    }
    
    if(empty($destino)){
        $errores[] = "El destino no puede estar vacío.";
    }
    
    if($origen == $destino){
        $errores[] = "El origen y destino no pueden ser iguales.";
    }
    
    if(empty($plazas_libres) || !is_numeric($plazas_libres) || $plazas_libres < 0){
        $errores[] = "Las plazas libres deben ser un número válido mayor o igual a 0.";
    }
    
    if(!empty($matricula)){
        $autobus = getBusMatricula($matricula);
        // Verificamos que las plazas libres no superen las plazas del bus
        if($autobus && $plazas_libres > $autobus->Num_plazas){
            $errores[] = "Las plazas libres no pueden superar las plazas del autobús (" . $autobus->Num_plazas . ").";
        }
    }
    
    // Si no hay errores se inserta
    if(empty($errores)){
        if(addViaje($fecha, $matricula, $origen, $destino, $plazas_libres)){
            $mensaje = "<p>Viaje añadido correctamente</p>";
            $fecha = $matricula = $origen = $destino = $plazas_libres = "";
        }else{
            $mensaje = "<p>Error: Ya existe un viaje con esa fecha, origen y destino</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir viaje</title>
</head>
<body>
        <?php
    echo $mensaje ."<br><br><br><br>";

    if(!empty($errores)){
        echo "<div>";
        echo "<h3>Errores:</h3>";
        echo "<ul>";
        foreach($errores as $error){
            echo "<li>$error</li>";
        }
        echo "</ul>";
        echo "</div>";
    }
    
    ?>

    <form action="" method="post">
        Fecha: <input type="date" name="fecha" value="<?php echo $fecha; ?>" required><br><br>
        
        Matrícula: 
        <select name="matricula" required>
            <option value="">Seleccione...</option>
            <?php
            foreach($autobuses as $bus){
                $selected = ($matricula == $bus->Matricula) ? "selected" : "";
                echo "<option value='$bus->Matricula' $selected>$bus->Matricula - $bus->Marca ($bus->Num_plazas plazas)</option>";
            }
            ?>
        </select><br><br>
        
        Origen: <input type="text" name="origen" value="<?php echo $origen; ?>" required><br><br>
        
        Destino: <input type="text" name="destino" value="<?php echo $destino; ?>" required><br><br>
        
        Plazas libres: <input type="number" name="plazas_libres" value="<?php echo $plazas_libres; ?>" min="0" required><br><br>
        
        <input type="submit" name="enviar" value="Añadir">
        <a href="index.php">Volver al menu</a>
    </form>
</body>
</html>