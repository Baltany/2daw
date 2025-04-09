<?php
function generarMatriz($filas,$columnas){
    $matriz = array();
    for($i=0;$i < $filas;$i++){
        for($j=0;$j < $columnas;$j++){
            $matriz[$i][$j] = rand(1,10);
        }
    }
    return pintarMatriz($matriz);
}

function pintarMatriz($matriz){

    $html = "<table>";
    foreach($matriz as $fila){
        $html = $html ."<tr>";
        foreach($fila as $columna){
            $html = $html ."<td>". $columna ."</td>";
        }
        $html = $html . "</tr>";

    }

    return $html . "</table>";
}

$filas=2;
$columnas=2;
$matriz = generarMatriz($filas,$columnas);

?>