<?php
$connection = new mysqli("localhost","dwes","abc123.","empleados");
echo $connection -> server_info;
$nombre = "Pepe";
$connection -> query("INSERT INTO datos (DNI,Nombre,Apellidos,Salario) VALUES('12345678b','$nombre','$nombre','15')");


?>


