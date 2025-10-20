<?php
$driver=new mysqli_driver();
$driver->report_mode=0;
echo "Gestion de errores: ".$driver->report_mode."<br>";
$conex=new mysqli("localhost","dwes","abc123.","empleados");
echo $conex->server_info;
if ($conex->connect_errno){
    echo "ERRRO: ".$conex->connect_errno."-".$conex->connect_error;
    die("adios");
}
$nombre='pepe';
$conex->query("INSERT INTO datos(DNI,nombre,apellidos,Salario) VALUES('12345678B', '$nombre)");
echo "<br> ERROR ".$conex->errno." - ".$conex->error."<br>";
?>
<?php
$driver=new mysqli_driver();
$driver->report_mode=0;
echo "Gestion de errores: ".$driver->report_mode."<br>";
$conex=new mysqli("localhost","dwes","abc123.","empleados");
echo $conex->server_info;
if ($conex->connect_errno){
    echo "ERRRO: ".$conex->connect_errno."-".$conex->connect_error;
    die("adios");
}
$nombre='pepe';
$conex->query("INSERT INTO datos(DNI,nombre,apellidos,Salario) VALUES('12345678B', '$nombre)");
echo "<br> ERROR ".$conex->errno." - ".$conex->error."<br>";
?>