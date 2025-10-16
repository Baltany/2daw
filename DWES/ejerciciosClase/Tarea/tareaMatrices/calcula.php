<?php
require_once 'funciones.php';
$f = false;
$c = false;
$d = true;
// hacer un header para proteger las rutas y el usuario que quiera ver la matriz sino ha metido valores antes no pueda entrar o sea redirigido
if(isset($_POST['calcula'])){
    if(!empty($_POST['filas']) && is_numeric($_POST['filas']) && $_POST['filas'] > 0){
        $f = true;
    }
    if(!empty($_POST['col']) && is_numeric($_POST['col']) && $_POST['col'] > 0){
        $c = true;
    }
    // Tiene que ser cuadrada para que exista diagonal
    if($_GET['opc'] == 4 && $_POST['filas'] == $_POST['col']){
        $c = true;
    }
}
if(isset($_POST['calcula']) && $f && $c && $d){
    $matriz = crearMatriz($_POST['filas'],$_POST['col']);
    mostrarMatriz($matriz);
    switch($_GET['opc']){
        case 1:
            echo "Suma fila <br>";
            $sumaFinal = sumarFilas($matriz);
            foreach($sumaFinal as $ind=>$value){
                echo "La suma de la fila ". $ind . " es de:". $value . "<br>";
            }
            break;
        case 2:
            echo "Suma columnas <br>";
            $sumaFinal = sumarColumnas($matriz);
            foreach($sumaFinal as $ind=>$value){
                echo "La suma de la columna ". $ind . " es de:". $value . "<br>";
            }

            break;

        case 3:
            echo "Suma filas y columnas <br>";
            echo "Suma TOTAL de todas las filas <br>";
            $sumaFilas = sumarFilas($matriz);
            // sumamos el array filas que contiene todas las filas de la matriz
            $totalFilas = array_sum($sumaFilas);
            echo "Total: <b>" . $totalFilas . "</b><br><br>";

            // lo mismo con las col
            echo "Suma TOTAL de todas las columnas <br>";
            $sumaCol = sumarColumnas($matriz);
            $totalCol = array_sum($sumaCol);
            echo "Total: <b>" . $totalCol . "</b><br><br>";

            break;

        case 4:
            echo "Diagonal <br>";
            $sumaDiagonal = sumarDiagonal($matriz);
            echo "La suma de la diagonal es: <b>". $sumaDiagonal . "</b> ";
            break;

        case 5:
            echo "Traspuesta <br>";
            $traspuesta = matrizTraspuesta($matriz);
            echo "<br>";
            mostrarMatriz($traspuesta);

            break;


    }
}else{



?>

<form action="" method="POST">
    Número de filas <input type="text" name="filas"><br>
    <?php if(!$f && isset($_POST['calcula'])) echo "<span style = color:red>La fila no puede estar vacía ni debe ser negativo </span> <br>";?>
    Número de columnas <input type="text" name="col"><br>
    <?php if(!$c && isset($_POST['calcula'])) echo "<span style = color:red>La columna no puede estar vacía ni debe ser negativo </span><br>";?>
    <?php if(! $d) ?>
    <input type="submit" name="calcula" value="calcula">

</form>
<br>
<a href="index.html">Menú</a>

<?php
}

?>