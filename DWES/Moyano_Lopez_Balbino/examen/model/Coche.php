<?php
class Coche{
    private $matricula;
    private $marca;
    private $modelo;
    private $km;
    private $foto;
    private $dni_cliente;

    public function __construct($matricula = "", $marca = "", $modelo = "", $km = 0, $foto = "", $dni_cliente = ""){
        $this->matricula = $matricula;
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->km = $km;
        $this->foto = $foto;
        $this->dni_cliente = $dni_cliente;
    }

    public function __get(string $name): mixed{
        return $this->$name;
    }

    public function __set(string $name, mixed $value): void{
        $this->$name = $value;
    }
}
?>