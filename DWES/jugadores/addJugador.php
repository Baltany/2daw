<?php
// Necesitamos recoger la conexion ya que tenemos hacer un get de las posciones que hay
require_once 'conexion.php';
require_once 'funciones.php';
if(!isset($_POST['enviar'])){

?>
<form action="" method="POST">
    Nombre: <input type="text" name="nombre"><br>
    DNI: <input type="text" name="dni"><br>
    Dorsal: <input type="text" name="dorsal"><br>
    <!-- TENGO QUE RECOGER LOS REGISTROS DEL SET QUE HAY EN LA BBDD POR/DEF/MED/DEL-->
    Posicion: <select type="text" name="posicion"><br>
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