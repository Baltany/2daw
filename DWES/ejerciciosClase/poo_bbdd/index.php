<?php
require_once 'Producto.php';
if(isset($_POST['insertar'])){
    $p = new Producto($_POST['cod'],$_POST['nombre'],$_POST['precio']);
    if($p->insertar())
        echo "<br> Producto insertado correctamente <br>";
    else
        echo "No se ha podido insertar el producto";

}
if(isset($_POST['buscar'])){
    
}

?>

<form action="" method="post">
    Codigo: <input type="text" name="cod"><br>
    Nombre: <input type="text" name="nombre"><br>
    Precio: <input type="text" name="precio"><br>
    <input type="submit" value="Insertar" name="insertar"><br>
    <input type="submit" value="Buscar" name="buscar"><br>
    <input type="submit" value="Mostrar" name="mostrar"><br>
    

</form>