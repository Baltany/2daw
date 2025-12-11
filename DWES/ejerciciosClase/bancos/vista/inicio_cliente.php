<?php
session_start();
if(!isset($_COOKIE['usuario_dni'])){
    header("Location:index.php");
    exit;
}

$dni = $_COOKIE['usuario_dni'];

require_once '../controller/CuentaController.php';
require_once '../model/Cuenta.php';

// Obtener todas las cuentas del usuario
$cuentas = CuentaController::obtenerPorDni($dni);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio Cliente</title>
</head>
<body>

<h1>Bienvenido <?php echo $_COOKIE['usuario_nombre'] ?></h1>
<p>DNI: <?php echo $_COOKIE['usuario_dni']; ?></p>

<a href="logout.php">Cerrar Sesión</a>

<hr>

<h2>Mis Cuentas</h2>

<?php
if($cuentas){
    echo "<table border='1'>";
    echo "<tr><th>IBAN</th><th>Saldo</th></tr>";

    foreach($cuentas as $c){
        echo "<tr>";
        echo "<td>" . $c->iban . "</td>";
        echo "<td>" . $c->saldo . " €</td>";
        echo "</tr>";
    }

    echo "</table>";
}else{
    echo "<p>No tienes cuentas registradas.</p>";
}
?>

<hr>

<a href="transferencias.php">Realizar Transferencia</a>

</body>
</html>
