<?php
// Necesitamos recoger la conexion ya que tenemos hacer un get de las posciones que hay
require_once 'conexion.php';
require_once 'funciones.php';
if(!isset($_POST['enviar'])){
    //leemos las posiciones que hay
    $posiciones = getPosiciones();
?>
<form action="" method="POST">
    Nombre: <input type="text" name="nombre"><br>
    DNI: <input type="text" name="dni"><br>
    Dorsal: <input type="text" name="dorsal"><br>
    <!-- Recorremos las posiciones que hay en la bbdd-->
    Posicion: <select type="text" name="posicion[]" multiple>
            <?php
            foreach($posiciones as $posicion){
            ?>
            <option value="<?php echo $posicion;?>"></option>    
            <?php
            }
            ?>
            </select>
    <br>
    Equipo: <input type="text" name="equipo"><br>
    Goles: <input type="text" name="goles"><br>
    <input type="submit" name="enviar" value="Enviar">
</form>

<?php
}
else{
    //Recogemos los datos del formulario


}
?>