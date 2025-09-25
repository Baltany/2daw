<?php
function esBisiesto($year){
    if($year % 400 == 0){
        return true;
    } else if($year % 100 ==0){
        return true;

    }else if($year % 4 == 0){
        return true;
    }
    else{
        return false;
    }
}
$year = 2025;
if(esBisiesto($year)){
    echo "El año $year es bisiesto";
}
else{
    echo "El año $year no es bisiesto";
}
?>

<?php
function generarNumAleatorio($num1,$num2){
    return rand($num1,$num2);
}

$primerNumero = genNumeroAleatorio(1,100);
if($primerNumero % 2 ==0){
    $primerNumero++;
}

echo "<table border='1'>";

$numero = $primerNumero;

for ($i=0;$i<10;$i++){
    echo "<tr>";
    for($j=0;$j<10;$j++){
        echo "<td style='border: 1px solid black;> $numero </td>";
        $numero+=2;
    }
    echo "</tr>";
}
echo "</table>";
?>


