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
}

function sumarFilas($matriz){
    foreach($matriz as $fila){
        $suma = 0;
        foreach($fila as $value){
            $suma += $value; 
        }
        $sumaFinal[] = $suma;
    }
}

?>