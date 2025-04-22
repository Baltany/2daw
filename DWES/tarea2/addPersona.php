<?php
require_once 'funciones.php';
//Simular agenda
$agenda = [];
$id = 1;
if(!isset($_POST['enviar'])) {
?>
<form action="" method="POST">
    Nombre:<input type="text" name="nombre"><br>
    Número de teléfono:<input type="text" name="ntelefono"><br>
    <input type="submit" name="enviar" value="Enviar">
</form>
<?php
}
else{
    $nombre = $_POST['nombre'];
    $ntelefono = $_POST['ntelefono'];
    addPersona($agenda, $nombre, $ntelefono, $id);
    showPersona($agenda);
}
?>