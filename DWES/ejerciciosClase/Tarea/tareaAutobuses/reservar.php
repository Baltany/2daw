<?php
require_once 'funciones.php';

// obtenemos los origenes y destinos que existen para hacer la reserva
$origenes = getOrigenesDisponibles();
$destinos = getDestinosDisponibles();

$viaje = null;
//definimos fecha = "" origen = "" y destino = ""
$fecha = $origen = $destino = "";
$mostrar_resultado = false;
$mensaje = "";

// hacer CONSULTA
if(isset($_POST['enviar'])){
    $fecha = $_POST['fecha'];
    $origen = $_POST['origen'];
    $destino = $_POST['destino'];
    
    $viaje = consultarViaje($fecha, $origen, $destino);
    $mostrar_resultado = true;
}

// hacer RESERVA
if(isset($_POST['reservar'])){
    $fecha = $_POST['fecha'];
    $origen = $_POST['origen'];
    $destino = $_POST['destino'];
    
    if(reservarAsiento($fecha, $origen, $destino)){
        $mensaje = "<p>Plaza reservada correctamente</p>";
        $viaje = consultarViaje($fecha, $origen, $destino);
        $mostrar_resultado = true;
    }else{
        $mensaje = "<p>No se pudo reservar. No hay plazas disponibles.</p>";
        $viaje = consultarViaje($fecha, $origen, $destino);
        $mostrar_resultado = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de Viajes</title>
</head>
<body>
    <?php echo $mensaje; ?>
    
    <?php if(!$mostrar_resultado): ?>
    <!-- Hacer consulta -->
    <form action="" method="post">
        Fecha <input type="date" name="fecha" required><br><br>
        Origen <select name="origen" id="origen" required>
            <option value="">Seleccione ...</option>
            <?php foreach($origenes as $origen){
                echo "<option value='$origen'>$origen</option>";
            } ?>
        </select><br><br>
        Destino <select name="destino" id="destino">
            <option value="">Seleccione ...</option>
            <?php
                foreach($destinos as $destino){
                    echo "<option value='$destino'>$destino</option>";
                }
            ?>

        </select><br><br>
        <input type="submit" name="enviar" value="Hacer consulta">
    </form>


    <?php else: ?>

    <!-- Hacer reserva -->
    <form action="" method="post">
        Fecha <input type="date" name="fecha" value="<?php echo $fecha; ?>" readonly><br><br>
        Origen <input type="text" name="origen" value="<?php echo $origen; ?>" readonly><br><br>
        Destino <input type="text" name="destino" value="<?php echo $destino; ?>" readonly><br><br>

        Disponibilidad <input type="text" value="<?php echo $viaje ? $viaje->Plazas_libres . ' plazas' : ' 0 plazas' ?>" readonly><br><br>
        <?php
            if($viaje && $viaje->Plazas_libres > 0):
        ?>
                <input type = "submit" name="reservar" value="Hacer Reserva">
        <?php
            else:
        ?>
            <p>No hay plazas disponibles para este viaje </p>
        <?php endif; 
        ?>

        <a href="reservar.php">Nueva consulta</a>
    </form>
    <?php endif; ?>

    <br>
    <a href="index.php">Volver al menu</a>
</body>
</html>
