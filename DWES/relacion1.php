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