<?php
class Empleado {

    private $id;
    private $email;
    private $pass;
    private $nombre;
    private $salario;
    private $departamento;

    public function __construct($id,$e, $p, $n, $s, $d) {
        $this->id = $id;
        $this->email = $e;
        $this->pass = $p;
        $this->nombre = $n;
        $this->salario = $s;
        $this->departamento = $d;
    }
    
    public function __get(string $name): mixed {
        return $this->$name;
    }
    
    public function __set(string $name, mixed $value): void {
        $this->$name = $value;
    }
}

?>