<?php
class Parte{

    private $dni_p;
    private $dni_a;
    private $motivo;
    private $time;
    
    private $foto;
    
    private $id;
    


    public function __construct($dni_p = "", $dni_a = "", $time = "",$foto="", $motivo = "",$id=0) {
        $this->dni_p = $dni_p;
        $this->dni_a = $dni_a;
        $this->time = $time;
        $this->foto = $foto;
        $this->motivo = $motivo;
        $this->id = $id;

    }

    public function __get(string $name): mixed {
        return $this->$name;
    }
    
    public function __set(string $name, mixed $value): void {
        $this->$name=$value;
    }


}
?>