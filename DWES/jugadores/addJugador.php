<?php
// Necesitamos recoger la conexion ya que tenemos hacer un get de las posciones que hay
require_once 'funciones.php';

//leemos las posiciones que hay
$posiciones = getPosiciones();


?>
<form action="" method="POST">
    Nombre: <input type="text" name="nombre"><br>
    DNI: <input type="text" name="dni"><br>
    Dorsal: <input type="text" name="dorsal"><br>
    <!-- Recorremos las posiciones que hay en la bbdd-->
    Posicion: <select type="text" name="posicion" >
            <?php
            while($row = $posiciones->fetch_object()){
            ?>
            <option value="<?php echo $row->posicion; ?>"> <?php echo $row->posicion; ?></option>    
            <?php
            }
            ?>
            </select>
    <br>
    Equipo: <input type="text" name="equipo"><br>
    Goles: <input type="text" name="goles"><br>
    <input type="submit" name="enviar" value="Enviar">
</form>

<a href="index.html">Volver</a>
<br>
<br>

<?php
if(isset($_POST['enviar'])){
    //Recogemos los datos del formulario
    $nombre= $_POST['nombre'];
    $dni= $_POST['dni'];
    $dorsal= $_POST['dorsal'];
    $posicion= $_POST['posicion'];
    $equipo= $_POST['equipo'];
    $goles= $_POST['goles'];
    addJugador($nombre,$dni,$dorsal,$posicion,$equipo,$goles);

}
?>