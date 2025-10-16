<?php
function crearMatriz($f,$c){
    for($i=0;$i<$f;$i++){
        for($j=0;$j<$c;$j++){
            $matriz[$i][$j] = random_int(1,100); 
        }
    }
    return $matriz;
}


function mostrarMatriz($matriz){
    echo "<table border=1> ";
    foreach($matriz as $fila){
        echo "<tr>";
        foreach($fila as $value){
            echo "<td>" . $value . "<td>";
        }
        echo "</tr>";
    }
    echo "</table>";
}

function sumarFilas($matriz){
    foreach($matriz as $fila){
        $suma = 0;
        foreach($fila as $value){
            $suma += $value; 
        }
        $sumaFinal[] = $suma;
    }
    return $sumaFinal;
}

function sumarColumnas($matriz){
    $sumaFinal = [];
    // contamos cuantas columas tiene la matriz
    $numCol = count($matriz[0]);

    for($i = 0; $i < $numCol;$i++){
        $suma = 0;
        foreach($matriz as $fila){
            $suma += $fila[$i];
        }
        $sumaFinal[] = $suma;
    }
    return $sumaFinal;

}

function sumarDiagonal($matriz){
    $suma = 0;
    // contamos el numero de filas que tiene que ser igual que el de col
    $numFilas = count($matriz);
    for($i=0;$i<$numFilas;$i++){
        $suma += $matriz[$i][$i]; 
    }
    return $suma;
}

function matrizTraspuesta($matriz){
    $traspuesta = [];
    $numFilas = count($matriz);
    $numCol = count($matriz[0]);

    // invertimos el orden de filas y col
    // defino j como columna e i como fila de ahi que invierta el orden en este caso
    for($j=0;$j<$numCol;$j++){
        for($i=0;$i<$numFilas;$i++){
            $traspuesta[$j][$i] = $matriz[$i][$j];

        }
    }
    return $traspuesta;
}

?>