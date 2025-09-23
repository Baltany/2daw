<?php
setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'esp');
echo "La fecha actual de hoy es ". date("d-m-Y");
echo "<br>".date(DATE_RFC2822);
echo "<br>".date('l j \d\e\ F Y ');
// echo no devuelve nada y print devuelve un entero 1 si se muestra 0 sino muestra nada 
// echo print($variable);

?>