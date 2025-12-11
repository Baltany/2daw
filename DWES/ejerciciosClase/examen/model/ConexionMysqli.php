<?php
class ConexionMysqli extends mysqli{
    private $host = "localhost";
    private $usu = "dwes";
    private $pass = "abc123.";
    private $bd = "sistema_usuarios";
    
    public function __construct(){
        parent::__construct($this->host, $this->usu, $this->pass, $this->bd);
        $this->set_charset("utf8");
    }
    
    public function __get(string $name): mixed{
        return $this->$name;
    }
    
    public function __set(string $name, mixed $value): void{
        $this->$name = $value;
    }
}
?>