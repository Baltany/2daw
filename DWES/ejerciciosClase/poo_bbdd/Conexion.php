<?php

class Conexion extends mysqli{
    private $host;
    private $usuario;
    private $pass;
    private $bbdd;


    // public function __construct() {
    //         parent::__construct($this->host,$this->usuario,$this->pass,$this->bbdd);
    //     }
    // crear una bbdd para objetos inventada que n ola he creado de ahiq ue no tenga nombre la $bbdd
    public function __construct($host="localhost",$usuario="dwes",$pass="abc123.",$bbdd="") {
        $this->host = $host;
        $this->usuario = $usuario;
        $this->pass = $pass;
        $this->bbdd = $bbdd;
    }

    public function __get(string $name){
        return $this->name;
    }

    public function __set(string $name,mixed $value){
        return $this->$name=$value;
    }


}



?>