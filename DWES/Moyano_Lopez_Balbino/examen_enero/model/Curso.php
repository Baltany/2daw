<?php
class Curso{

    private $id_curso;
    private $descripcion;
    private $totalpartes;

    


    public function __construct($id_curso = 0, $descripcion = "", $totalpartes = "") {
        $this->id_curso = $id_curso;
        $this->descripcion = $descripcion;
        $this->totalpartes = $totalpartes;

    }

    public function __get(string $name): mixed {
        return $this->$name;
    }
    
    public function __set(string $name, mixed $value): void {
        $this->$name=$value;
    }

    

}
?>