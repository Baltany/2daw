<?php
require_once 'funciones.php';

$filas=3;
$columnas=3;
$matriz = generarMatriz($filas,$columnas);

echo(pintarMatriz($matriz));


// La suma de la filas de una matriz -->
echo "La suma de las filas de la matriz generada automaticamente es: ";

print_r(sumarFilas($matriz));


echo "<br>";
echo "<br>";
echo "<br>";

//La suma de las columnas de una matriz -->
echo "La suma de las columnas de una matriz generada automaticamente es: ";

print_r(sumarColumnas($matriz));


echo "<br>";
echo "<br>";

// La suma de las filas y las columnas de una matriz

echo "La suma de las filas y columnas de una matriz generada automaticamente es: ";



echo(sumasFilasColumnas($matriz));


// La suma de la diagonal principal de una matriz

echo "<br>";
echo "<br>";

echo "La suma de la diagonal principal de la matriz generada automaticamente es: ";
echo(sumaDiagonal($matriz));


echo "<br>";
echo "<br>";
// Calcular la matriz traspuesta


echo "La matriz transpuesta de la matriz generada automaticamente es: ";
echo pintarMatriz(calcularTraspuesta($matriz));
?>

