<?php

/*CAMBIAR A MYSQLI*/
class Conexion{
    private $host = "localhost";
    private $usu = "dwes";
    private $pass = "abc123.";
    private $bd = "partes";
    private $conexion;
    
    public function __construct(){
        try{
            $opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
            $this->conexion = new PDO("mysql:host=$this->host;dbname=$this->bd", $this->usu, $this->pass, $opciones);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            die("Error de conexión: " . $e->getMessage());
        }
    }
    
    public function getConexion(){
        return $this->conexion;
    }
}

/*<?php
class Conexion extends mysqli{
    private $host = "localhost";
    private $usu = "dwes";
    private $pass = "abc123.";
    private $bd = "partes"; 
    
    public function __construct(){
        parent::__construct($this->host, $this->usu, $this->pass, $this->bd);
        $this->set_charset("utf8");
        
        if($this->connect_error){
            die("Error de conexión: " . $this->connect_error);
        }
    }
}
?>
*/

?>