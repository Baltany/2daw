<?php
class Tarea{
    private $id;
    private $descripcion;
    private $precio;
    private $tipo;

    public function __construct($id = 0, $descripcion = "", $precio = 0, $tipo = ""){
        $this->id = $id;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->tipo = $tipo;
    }

    public function __get(string $name): mixed{
        return $this->$name;
    }

    public function __set(string $name, mixed $value): void{
        $this->$name = $value;
    }
}
?>