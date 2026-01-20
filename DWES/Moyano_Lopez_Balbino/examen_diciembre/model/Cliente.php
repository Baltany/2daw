<?php
class Cliente{
    private $dni;
    private $nombre;
    private $direccion;
    private $telf;


    public function __construct($dni="",$nombrecompleto="",$direccion="",$telf="") {
        $this->dni=$dni;
        $this->nombrecompleto=$nombrecompleto;
        $this->direccion=$direccion;
        $this->telf=$telf;

    }

    public function __get(string $name): mixed {
        return $this->$name;
    }
    
    public function __set(string $name, mixed $value): void {
        $this->$name=$value;
    }
}


?>