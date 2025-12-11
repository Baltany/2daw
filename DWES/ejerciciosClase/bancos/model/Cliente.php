<?php
class Cliente{
    private $dni;
    private $nombre;
    private $direccion;
    private $telefono;
    private $clave;
    private $intentos;
    private $bloqueado;
    
    public function __construct($dni="",$nombre="",$direccion="",$telefono="",$clave="",$intentos="",$bloqueado="") {
        $this->dni=$dni;
        $this->nombre=$nombre;
        $this->direccion=$direccion;
        $this->telefono=$telefono;
        $this->clave=$clave;
        $this->intentos=$intentos;
        $this->bloqueado=$bloqueado;
    }
    
    public function __get(string $name): mixed {
        return $this->$name;
    }
    
    public function __set(string $name, mixed $value): void {
        $this->$name=$value;
    }
    
    public function __toString(): string {
        return "<br>Cliente[dni=" . $this->dni
                . ", nombre=" . $this->nombre
                . ", direccion=" . $this->direccion
                . ", telefono=" . $this->telefono
                . "]<br>";
    }
}
?>