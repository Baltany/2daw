<?php
class Alumno{

    private $dni_a;
    private $nombre;
    private $apellidos;
    private $direccion;
    
    private $telf;
    
    private $id_curso;
    private $intentos;
    


    public function __construct($dni_a = "", $nombre = "", $direccion = "",$telf="", $apellidos = "",$id_curso="") {
        $this->dni_a = $dni_a;
        $this->nombre = $nombre;
        $this->direccion = $direccion;
        $this->telf = $telf;
        $this->apellidos = $apellidos;
        $this->id_curso = $id_curso;

    }

    public function __get(string $name): mixed {
        return $this->$name;
    }
    
    public function __set(string $name, mixed $value): void {
        $this->$name=$value;
    }


}
?>