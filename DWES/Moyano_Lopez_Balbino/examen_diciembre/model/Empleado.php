<?php
class Empleado{
    private $codigo;
    private $clave;
    private $nombre;
    private $telf;
    private $rol;


    public function __construct($codigo="",$clave="",$nombre="",$telf="",$rol="mecanico") {
        $this->codigo=$codigo;
        $this->clave=$clave;
        $this->nombre=$nombre;
        $this->telf=$telf;
        $this->rol=$rol;

    }

    public function __get(string $name): mixed {
        return $this->$name;
    }
    
    public function __set(string $name, mixed $value): void {
        $this->$name=$value;
    }
    
    public function esAdmin(): bool {
        return $this->rol === 'admin';
    }
    
    public function esMecanico(): bool {
        return $this->rol === 'mecanico';
    }
    
    public function __toString(): string {
        return "<br>Empleado[codigo=" . $this->codigo
                . ", nombre=" . $this->nombre
                . ", telf=" . $this->telf
                . ", rol=" . $this->rol
                . ", clave=" . $this->clave
                . "]<br>";
    }
    


}

?>