<?php
require_once 'funciones.php';
$agenda= []; 
$persona1 = new Persona('1','nombre1','123456789');
$persona2 = new Persona('2','nmbre1','12345789');
$persona3 = new Persona('3','nombr1','13456789');
$agenda.array_push($agenda,$persona1);
$agenda.array_push($agenda,$persona2);
$agenda.array_push($agenda,$persona3);



showPersona($agenda);
?>