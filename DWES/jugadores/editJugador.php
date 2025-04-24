<?php
require_once "funciones.php";
$jugadores = getJugador();
?>

<table border="1">
    <tr>
        <th>Nombre</th>
        <th>DNI</th>
        <th>Dorsal</th>
        <th>Posicion</th>
        <th>Equipo</th>
        <th>Goles</th>
    </tr>
    <?php foreach($jugadores as $jugador): ?>
    <tr>
    <td><?php echo $jugador->nombre; ?></td>
    <td><?php echo $jugador->dni; ?></td>
    <td><?php echo $jugador->dorsal; ?></td>
    <td><?php echo $jugador->posicion; ?></td>
    <td><?php echo $jugador->equipo; ?></td>
    <td><?php echo $jugador->goles; ?></td>
    <td><button>Editar</button></td>
    </tr>
<?php endforeach; ?>
</table>
<br>
<br>


<a href="index.html">Volver</a>