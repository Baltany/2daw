<?php
function getConexion(){
    $host = "localhost";
    $user = "dwes";
    $password = "abc123.";
    $dbname = "jugadores";

    try{
        $connection = new mysqli($host,$user,$password,$dbname);
    }
    catch(Exception $exception){
        echo $exception -> getMessage();
    }
    return $connection;
}


?>