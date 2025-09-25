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

<?php
function esMayor($a,$b,$c){
    if($a>$b && $a>$c){
        return $a;
    }else if($b>$c && $b>$a){
        return $b;
    }else{
        return $c;
    }

$a = 100;
$b = 5000;
$c = 1;

echo "El número mayor es: " . esMayor($a, $b, $c);
}
?>


<?php
echo "<table border='1' style='border'>";
$i = 0;
while($i<5){
    echo "<tr>";
    $j = 0;
    while($j<7){
        echo "<td>" . ($i*7 + $j + 1). "</td>";
        $j++;
    }
    echo "</tr>";
    $i++;

}
echo "</table>";

?>

<?php

?>

