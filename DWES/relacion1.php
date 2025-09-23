<!-- Dado un año, indicar si es bisiesto o no.
Para determinar si un año es bisiesto, siga estos pasos:
a) Si el año es uniformemente divisible por 4, vaya al paso b.De lo contrario,
vaya al paso e.
b) Si el año es uniformemente divisible por 100, vaya al paso c.De lo
contrario, vaya al paso d.
c) Si el año es uniformemente divisible por 400, vaya al paso d.De lo
contrario, vaya al paso e.
d) El año es un año bisiesto(tiene 366 días).
e) El año no es un año bisiesto(tiene 365 días). -->
<?php

function esBisiesto($year) {
    if ($year % 400 == 0) {
        return true;
    } else if ($year % 100 == 0) {
        return true;
    }
    else if($year % 4 == 0) {
        return true;
    }else {
        return false;
    }
}

$year = 2024;
if(esBisiesto($year)){
    echo "El año $year es bisiesto. ";

}else{
    echo "El año $year no es bisiesto. ";
}
?>

<!-- Mostrar en pantalla una tabla de 10 por 10 con
  los números impares a partir de 
uno generado al azar. Se debe ver en 
el navegador los bordes de la tabla. -->
<?php

    function genNumeroAleatorio($num1,$num2) {
        return rand($num1,$num2);
    }

    $primerNumero = genNumeroAleatorio(1,100);
    if($primerNumero % 2 == 0){
        $primerNumero++;
    }

    echo "<table border='1' style='border-collapse: collapse;'>";

    $numero = $primerNumero;

    for($i=0;$i<10;$i++){
        echo "<tr>";
        for($j=0;$j<10;$j++){
            echo "<td style='border: 1px solid black;'>$numero</td>";
            $numero+=2;
        }
        echo "</tr>";
    }

    echo "</table>";

?>



<!-- De tres números A, B y C mostrar el valor  máximo -->
<?php
    function esMayor($a,$b,$c){
        if($a>$b && $a>$c){
            return $a;
        }else if($b>$c && $b>$a){
            return $b;
    }
    else{
        return $c;
    }
}

$a = 10;
$b = 20;
$c = 15;

echo "El número mayor es: " . esMayor($a, $b, $c);
?>


<!-- Elabora un script que permita construir una tabla de 5 filas y 7 columnas que 
contengan los sucesivos números naturales desde 1 hasta 35. Utiliza bucles del 
tipo for, que igual que while y do while permiten ser anidados. -->
<?php
echo "<table border='1' style='border-collapse: collapse;'>";

for($i=0; $i<5; $i++){
    echo "<tr>";
    for($j=0; $j<7; $j++){
        echo "<td>". ($i*7 + $j + 1). "</td>";
    }
    echo "</tr>";
    
}

echo "</table>";
?>

<!-- Repite el ejercicio anterior usando while y do while. -->
<?php
echo "<table border='1' style='border-collapse: collapse;'>";

$i = 0;
while($i<5){
    echo "<tr>";
    $j = 0;
    while($j<7){
        echo "<td>". ($i*7 + $j + 1). "</td>";
        $j++;
    }
    echo "</tr>";
    $i++;
    
}
?>

<!-- Sumar los números enteros de 1 a 100 utilizando
 a) estructura (repetir) ;
 b) estructura (mientras) ;
 c) estructura (para). -->

<?php
// Estructura (repetir)
$suma = 0;
for($i=1; $i<=100; $i++){
    $suma += $i;
}
echo "La suma de los numeros enteros de 1 a 100 es: $suma <br>";

// Estructura (mientras)
$suma = 0;
$i = 1;
while($i<=100){
    $suma += $i;
    $i++;
}
echo "La suma de los numeros enteros de 1 a 100 es: $suma <br>";

// Estructura (para)
$suma = 0;
for($i=1; $i<=100; $i++){
    $suma += $i;
}
echo "La suma de los numeros enteros de 1 a 100 es: $suma";

?>

<!-- Calcular la suma de los cuadrados de los 100 primeros números enteros. -->
<?php
$suma = 0;
for($i=1; $i<=100; $i++){
    $suma += $i * $i;
}
echo "La suma de los cuadrados de los 100 primeros numeros enteros es: $suma";
?>

<!-- Calcule la suma de los 100 primeros números enteros pares. -->
<?php
$suma = 0;
for($i=2; $i<=200; $i+=2){
    $suma += $i;
}
echo "La suma de los 100 primeros numeros pares es: $suma";

?>

<!-- Ordena tres números de mayor a menor. -->
<?php
$a = 10;
$b = 20;
$c = 30;

if($a < $b){
    $aux = $a;
    $a = $b;
    $b = $aux;
    }
if($a < $c){
    $aux = $a;
    $a = $c;
    $c = $aux;
}
if($b < $c){
    $aux = $b;
    $b = $c;
    $c = $aux;
}
echo "El orden de los numeros es: $a, $b, $c";


?>
