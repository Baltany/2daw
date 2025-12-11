<?php
session_start();
if(!isset($_COOKIE['usuario_dni'])) { header("Location:index.php"); exit; }

require_once '../controller/CuentaController.php';
require_once '../model/Cuenta.php';

$mensaje = "";
$transferenciaRealizada = false;

// -------------------------------------------------------------------------
// CASO 2: EL USUARIO YA PULSÓ "CONFIRMAR" (Ejecutamos la lógica aquí)
// -------------------------------------------------------------------------
if (isset($_POST['confirmar'])) {
    $origen = $_POST['iban_origen'];
    $destino = $_POST['iban_destino'];
    $cantidad = $_POST['cantidad'];
    
    // Llamamos a la función con transacción que acabamos de hacer
    $resultado = CuentaController::realizarTransferenciaConTransaccion($origen, $destino, $cantidad);
    
    if ($resultado === true) {
        $transferenciaRealizada = true;
    } else {
        $mensaje = "Error: " . $resultado;
    }
}

// -------------------------------------------------------------------------
// CASO 1: EL USUARIO VIENE DE "TRANSFERENCIAS.PHP" (Mostrar Resumen)
// -------------------------------------------------------------------------
// Si no se ha confirmado aún, recogemos los datos para mostrar el resumen
if (!$transferenciaRealizada && isset($_POST['iban_origen'])) {
    $origen = $_POST['iban_origen'];
    $destino = $_POST['iban_destino'];
    $cantidad = $_POST['cantidad'];
    
    // Obtenemos datos de la cuenta para mostrar saldos (simulación visual)
    $cuentaObj = CuentaController::obtenerPorIban($origen);
    $saldoActual = $cuentaObj->saldo;
    $comision = 2; // Según pizarra
    $totalRestar = $cantidad + $comision;
    $saldoPosterior = $saldoActual - $totalRestar;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Validar Transferencia</title>
</head>
<body>

    <div style="float: right;">
        Hola <?php echo $_COOKIE['usuario_nombre']; ?> <br>
        <a href="logout.php">Cerrar Sesión</a>
    </div>

    <?php if ($transferenciaRealizada): ?>
        <h1>¡Transferencia Realizada!</h1>
        <p>La operación se ha completado correctamente.</p>
        <a href="inicio_cliente.php">Volver al inicio</a>

    <?php elseif ($mensaje != ""): ?>
        <h1>Ha ocurrido un error</h1>
        <p style="color:red;"><?php echo $mensaje; ?></p>
        <a href="transferencias.php">Volver a intentar</a>

    <?php else: ?>
        <h1>Confirmación Transferencia</h1>
        
        <div style="border: 1px solid black; padding: 20px; width: 300px;">
            <p><strong>Cuenta origen:</strong> <?php echo $origen; ?></p>
            <p><strong>Cuenta destino:</strong> <?php echo $destino; ?></p>
            <p><strong>Cantidad:</strong> <?php echo $cantidad; ?> €</p>
            <p><strong>Comisión:</strong> 2 €</p>
            <hr>
            <p>Saldo anterior: <?php echo $saldoActual; ?> €</p>
            <p><strong>Saldo posterior: <?php echo $saldoPosterior; ?> €</strong></p>
            
            <form action="" method="post">
                <input type="hidden" name="iban_origen" value="<?php echo $origen; ?>">
                <input type="hidden" name="iban_destino" value="<?php echo $destino; ?>">
                <input type="hidden" name="cantidad" value="<?php echo $cantidad; ?>">
                
                <input type="submit" name="confirmar" value="Confirmar">
            </form>
        </div>
    <?php endif; ?>

</body>
</html>