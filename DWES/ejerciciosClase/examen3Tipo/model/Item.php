<?php
class Item{
    private $id;
    private $nombre;
    private $apellidos;
    private $provincia;
    private $sexo;
    private $edad;
    private $estado_civil;
    private $aficiones;
    private $estudios;
    private $fecha_creacion;
    
    public function __construct($id=0,$nombre="",$apellidos="",$provincia="",$sexo="",$edad="",$estado_civil="",$aficiones="",$estudios="",$fecha_creacion="") {
        $this->id=$id;
        $this->nombre=$nombre;
        $this->apellidos=$apellidos;
        $this->provincia=$provincia;
        $this->sexo=$sexo;
        $this->edad=$edad;
        $this->estado_civil=$estado_civil;
        $this->aficiones=$aficiones;
        $this->estudios=$estudios;
        $this->fecha_creacion=$fecha_creacion;
    }
    
    public function __get(string $name): mixed {
        return $this->$name;
    }
    
    public function __set(string $name, mixed $value): void {
        $this->$name=$value;
    }
    
    public function __toString(): string {
        return "<br>Item[id=" . $this->id
                . ", nombre=" . $this->nombre
                . ", apellidos=" . $this->apellidos
                . "]<br>";
    }
}


?>