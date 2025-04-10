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
    echo "La suma de la diagonal principal de la matriz generada automaticamente es: ";
    echo(sumaDiagonal($matriz));

}

?>

<br>
<br>
<a href="index.html">Volver al index</a>