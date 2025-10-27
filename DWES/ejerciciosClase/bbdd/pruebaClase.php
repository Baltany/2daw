<?php

try{
    $connection = new mysqli("localhost","dwes","abc123.","dwes");
    $stmt = $connection -> prepare("INSERT INTO tienda (cod,nombre,tlf) VALUES (?,?,?)");

}
catch(mysqli_sql_exception $e){
    die($e->getMessage());
}
$cod = 4;
$nombre = "Sucursal4";
$tlf = "44444444";

$stmt -> bind_param("iss",$cod,$nombre,$tlf);

if($stmt -> execute())
    echo "Tienda insertada";



?>