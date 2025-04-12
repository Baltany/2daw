<?php
function generarMatriz($filas,$columnas){
    $matriz = array();
    for($i=0;$i < $filas;$i++){
        for($j=0;$j < $columnas;$j++){
            $matriz[$i][$j] = rand(1,10);
        }
    }
    return $matriz;
}

function pintarMatriz($matriz){

    $html = "<table border='1'>";
    foreach($matriz as $fila){
        $html = $html ."<tr>";
        foreach($fila as $columna){
            $html = $html ."<td>". $columna ."</td>";
        }
        $html = $html . "</tr>";

    }

    $html = $html . "</table>";
    return $html;
}

function sumarFilas($matriz){
    $suma = array();
    foreach($matriz as $fila){
        $sumaFila = 0;
        foreach($fila as $columna){
            $sumaFila += $columna;
        }
        array_push($suma, $sumaFila);
    }
    return $suma;
}

function sumarColumnas($matriz){
    $suma = array();
    // Contamos el numero de columnas de la matriz
    // y lo guardamos en la variable $numeroCol
    $numeroCol = count($matriz[0]);
    // Una vez que tenemos el numero de columnas y
    // recorremos la matriz y sumamos cada columna
    for($i=0;$i < $numeroCol;$i++){
        $sumaColumna = 0;
        // Recorremos cada fila de la matriz
        foreach($matriz as $fila){
            // Sumamos el elemento de la COLUMNA $i
            $sumaColumna += $fila[$i];
        }
        array_push($suma, $sumaColumna);
    }
    return $suma;
}

function sumasFilasColumnas($matriz){
    
    $arraySumaFilas = sumarFilas($matriz);
    $arraySumaColumnas = sumarColumnas($matriz);
    
    $sumaFilas = array_sum($arraySumaFilas);  // Sumar todas las sumas de las filas
    $sumaColumnas = array_sum($arraySumaColumnas);  // Sumar todas las sumas de las columnas


    return "La suma de las filas es: $sumaFilas y la suma de las columnas es: $sumaColumnas";

}


function sumaDiagonal($matriz){
    $sumaDiagonal = 0;
    // contamos numero de filas
    $numeroFilas = count($matriz);
    // recorremos el numero de filas
    for($i=0;$i < $numeroFilas;$i++){
        // sumamos el elemnento indicado la posicion [i]=fila y [i]=columna
        // es decir [i]=fila 1
        // [i]=columna 1 ...
        $sumaDiagonal += $matriz[$i][$i];
    }
    return $sumaDiagonal;
}


function calcularTraspuesta($matriz){
    $traspuesta = array();
    $numeroFilas = count($matriz);
    $numeroColumnas = count($matriz[0]); 

    for($i=0;$i<$numeroFilas;$i++){
        for($j=0;$j<$numeroColumnas;$j++){
            // invertimos filas y columnas
            // es decir la fila 1 se convierte en columna 1
            $traspuesta[$j][$i] = $matriz[$i][$j];
        }
    }
    return $traspuesta;
}

?>