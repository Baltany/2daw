<?php
$host = "localhost";
$user = "dwes";
$password = "abc123.";
$dbname = "jugadores";

$connection = new mysqli($host, $user, $password, $dbname);

if ($connection->connect_error) {
    die("Conexión fallida: " . $connection->connect_error);
}
?>
