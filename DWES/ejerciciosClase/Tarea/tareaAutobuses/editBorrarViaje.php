<?php
require_once 'funciones.php';

$viajes = getAllViajes();
$autobuses = getBus();

$mensaje = "";
$viaje_seleccionado = null;
$mostrar_formulario = false;
$errores = [];

// Buscar viaje para modificar/borrar
if(isset($_POST['buscar'])){
    $fecha = $_POST['fecha'];
    $origen = $_POST['origen'];
    $destino = $_POST['destino'];
    
    $viaje_seleccionado = consultarViaje($fecha, $origen, $destino);
    
    if($viaje_seleccionado){
        $mostrar_formulario = true;
    }else{
        $mensaje = "<p>No se encontró ningún viaje con esos datos</p>";
    }
}

// Modificar viaje
if(isset($_POST['modificar'])){
    $fecha_original = $_POST['fecha_original'];
    $origen_original = $_POST['origen_original'];
    $destino_original = $_POST['destino_original'];
    
    $matricula = $_POST['matricula'];
    $plazas_libres = $_POST['plazas_libres'];
    
    // Validaciones de las plazs libres
    if(empty($plazas_libres) || !is_numeric($plazas_libres) || $plazas_libres < 0){
        $errores[] = "Las plazas libres deben ser un número válido mayor o igual a 0.";
    }
    
    if(!empty($matricula)){
        $autobus = getBusMatricula($matricula);
        // Verificamos que plazas lbres no superen las plazas del bus
        if($autobus && $plazas_libres > $autobus->Num_plazas){
            $errores[] = "Las plazas libres no pueden superar las plazas del autobús (" . $autobus->Num_plazas . ").";
        }
    }
    
    if(empty($errores)){
        if(modificarViaje($fecha_original, $origen_original, $destino_original, $matricula, $plazas_libres)){
            $mensaje = "<p>Viaje modificado correctamente</p>";
            $mostrar_formulario = false;
        }else{
            $mensaje = "<p>Error al modificar el viaje</p>";
        }
    }else{
        $viaje_seleccionado = consultarViaje($fecha_original, $origen_original, $destino_original);
        $mostrar_formulario = true;
    }
}

// Borrar viaje
if(isset($_POST['borrar'])){
    $fecha = $_POST['fecha_original'];
    $origen = $_POST['origen_original'];
    $destino = $_POST['destino_original'];
    
    if(borrarViaje($fecha, $origen, $destino)){
        $mensaje = "<p>Viaje borrado correctamente</p>";
        $mostrar_formulario = false;
        $viajes = getAllViajes(); // Actualizar lista
    }else{
        $mensaje = "<p>Error al borrar el viaje</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar/Borrar Viaje</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>MODIFICAR/BORRAR VIAJE</h1>
    
    <?php echo $mensaje; ?>
    
    <?php
    if(!empty($errores)){
        echo "<div>";
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
    <!-- Listado de viajes -->
    <h2>Viajes disponibles</h2>
    <?php if($viajes && count($viajes) > 0): ?>
        <table>
            <tr>
                <th>Fecha</th>
                <th>Matrícula</th>
                <th>Origen</th>
                <th>Destino</th>
                <th>Plazas libres</th>
                <th>Acción</th>
            </tr>
            <?php foreach($viajes as $v): ?>
            <tr>
                <td><?php echo $v->Fecha; ?></td>
                <td><?php echo $v->Matricula; ?></td>
                <td><?php echo $v->Origen; ?></td>
                <td><?php echo $v->Destino; ?></td>
                <td><?php echo $v->Plazas_libres; ?></td>
                <td>
                    <form action="" method="post" style="display: inline;">
                        <input type="hidden" name="fecha" value="<?php echo $v->Fecha; ?>">
                        <input type="hidden" name="origen" value="<?php echo $v->Origen; ?>">
                        <input type="hidden" name="destino" value="<?php echo $v->Destino; ?>">
                        <input type="submit" name="buscar" value="Modificar/Borrar">
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No hay viajes disponibles</p>
    <?php endif; ?>
    
    <?php else: ?>
    <h2>Modificar o Borrar Viaje</h2>
    <form action="" method="post">
        <input type="hidden" name="fecha_original" value="<?php echo $viaje_seleccionado->Fecha; ?>">
        <input type="hidden" name="origen_original" value="<?php echo $viaje_seleccionado->Origen; ?>">
        <input type="hidden" name="destino_original" value="<?php echo $viaje_seleccionado->Destino; ?>">
        
        Fecha: <input type="date" value="<?php echo $viaje_seleccionado->Fecha; ?>" readonly><br><br>
        
        Origen: <input type="text" value="<?php echo $viaje_seleccionado->Origen; ?>" readonly><br><br>
        
        Destino: <input type="text" value="<?php echo $viaje_seleccionado->Destino; ?>" readonly><br><br>
        
        Matrícula: 
        <select name="matricula" required>
            <?php
            foreach($autobuses as $bus){
                $selected = ($viaje_seleccionado->Matricula == $bus->Matricula) ? "selected" : "";
                echo "<option value='$bus->Matricula' $selected>$bus->Matricula - $bus->Marca ($bus->Num_plazas plazas)</option>";
            }
            ?>
        </select><br><br>
        
        Plazas libres: <input type="number" name="plazas_libres" value="<?php echo $viaje_seleccionado->Plazas_libres; ?>" min="0" required><br><br>
        
        <input type="submit" name="modificar" value="Modificar">
        <input type="submit" name="borrar" value="Borrar" onclick="return 
        // confirm es como un alert pero devuelve boolean(true or false)
        confirm('¿Estás seguro de borrar este viaje?')">
        <a href="editBorrarViaje.php"><button type="button">Cancelar</button></a>
    </form>
    <?php endif; ?>
    
    <br>
    <a href="index.php">Volver al menu</a>
</body>
</html>