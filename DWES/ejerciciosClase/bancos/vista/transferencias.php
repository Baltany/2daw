<?php
session_start();

// 1. Verificación de seguridad
if(!isset($_COOKIE['usuario_dni'])){
    header("Location:index.php");
    exit;
}

require_once '../controller/CuentaController.php';
require_once '../model/Cuenta.php';

// 2. Obtener datos de la cuenta ORIGEN
if(isset($_GET['iban'])) {
    $iban_origen = $_GET['iban'];
    $cuentaOrigen = CuentaController::obtenerPorIban($iban_origen); 
    
    // Seguridad: Verificamos que la cuenta pertenezca al usuario
    if(!$cuentaOrigen || $cuentaOrigen->dni_cuenta != $_COOKIE['usuario_dni']){
        die("Error: Esa cuenta no te pertenece o no existe.");
    }

    // 3. Obtener posibles DESTINATARIOS (Para el desplegable)
    // Usamos la función que añadimos antes al Controller
    $cuentasDestino = CuentaController::obtenerOtrasCuentas($iban_origen);

} else {
    // Si entran sin elegir cuenta, fuera
    header("Location: inicio_cliente.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Realizar Transferencia</title>
</head>
<body>
    <div style="float: right;">
        Hola <?php echo $_COOKIE['usuario_nombre']; ?> <br>
        <a href="logout.php">Cerrar Sesión</a>
    </div>
    
    <h1>Transferencias</h1>

    <form action="validar_transferencia.php" method="post">
        
        <input type="hidden" name="iban_origen" value="<?php echo $cuentaOrigen->iban; ?>">

        <p>
            <strong>Cuenta origen:</strong> <?php echo $cuentaOrigen->iban; ?>
        </p>
        <p>
            <strong>Saldo:</strong> <?php echo $cuentaOrigen->saldo; ?> €
        </p>

        <label for="cantidad">Cantidad:</label><br>
        <input type="number" name="cantidad" id="cantidad" required min="1" step="0.01">
        <br><br>

        <label for="iban_destino">Cuenta destino:</label><br>
        
        <select name="iban_destino" required>
            <option value="" disabled selected>-- Selecciona una cuenta --</option>
            <?php
            if($cuentasDestino){
                foreach($cuentasDestino as $destino){
                    // Mostramos "Nombre - IBAN" tal como sugiere la pizarra
                    // $destino->nombre_propietario viene de la función obtenerOtrasCuentas
                    echo "<option value='" . $destino->iban . "'>" . $destino->nombre_propietario . " - " . $destino->iban . "</option>";
                }
            } else {
                echo "<option value='' disabled>No hay destinatarios disponibles</option>";
            }
            ?>
        </select>
        
        <br><br>
        <input type="submit" value="Transferir"> 
    </form>

</body>
</html>