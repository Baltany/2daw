<?php
require_once "funciones.php";
$jugadores = getJugador();

?>
<form action="" method="POST">
    <input type="text" name="buscador" placeholder="Busque aqui un jugador">
    <input type="submit" value="buscar" name="buscar">
</form>

<?php
if (isset($_POST['buscar'])){
    $nombre = $_POST['buscador'];
    buscarJugador($nombre);
}
?>

<br><br>
<a href="index.html">Volver</a>
