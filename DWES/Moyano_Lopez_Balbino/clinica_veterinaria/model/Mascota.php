<?php
class Mascota{
    private $id;
    private $nombre;
    private $especie;
    private $raza;
    private $edad;
    private $foto;
    private $id_usuario;
    private $fecha_registro;

    public function __construct($id = 0, $nombre = "", $especie = "", $raza = "", $edad="" ,$foto = "", $id_usuario = 0 ,$fecha_registro = "") {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->especie = $especie;
        $this->raza = $raza;
        $this->edad = $edad;
        $this->foto = $foto;
        $this->id_usuario = $id_usuario;
        $this->fecha_registro = $fecha_registro;
    }

    public function __get(string $name): mixed {
        return $this->$name;
    }
    
    public function __set(string $name, mixed $value): void {
        $this->$name=$value;
    }
}
?>