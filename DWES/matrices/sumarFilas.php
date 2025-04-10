<?php
require_once 'funciones.php';
if(!isset($_POST['enviar'])){
?>
<form action="" method="POST">
    Número filas:<input type="text" name="filas"><br>
    Número de columnas:<input type="text" name="col"><br>
    <input type="submit" name="enviar" value="Enviar">
</form>
<?php
}
else{

    $matriz = generarMatriz($_POST['filas'],$_POST['col']);
    echo(pintarMatriz($matriz));


// La suma de la filas de una matriz -->
    echo "La suma de las filas de la matriz generada automaticamente es: ";

    print_r(sumarFilas($matriz));
}


?>