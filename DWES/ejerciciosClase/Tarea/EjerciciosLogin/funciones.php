<?php
function getConnection(){

    try{
        $opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4");
        $connection = new PDO('mysql:host=localhost;dbname=dwes', 'dwes', 'abc123.',$opciones);
    }catch(mysqli_sql_exception $e){
        $e -> getMessage();
    }
    return $connection;
}

?>