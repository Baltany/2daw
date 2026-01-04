<?php
class Trabajo{
    private $matricula;
    private $cod_mecanico;
    private $id_tarea;
    private $fecha;
    private $estado;
    private $horas;

    public function __construct($matricula="",$cod_mecanico="",$id_tarea="",$fecha="",$estado="",$horas="") {
        $this->matricula=$matricula;
        $this->cod_mecanico=$cod_mecanico;
        $this->id_tarea=$id_tarea;
        $this->fecha=$fecha;
        $this->estado=$estado;
        $this->horas=$horas;

    }
    public function __get(string $name): mixed {
        return $this->$name;
    }
    
    public function __set(string $name, mixed $value): void {
        $this->$name=$value;
    }
    
    public function __toString(): string {
        return "<br>Trabajo=" . $this->matricula
                . ", saldo=" . $this->cod_mecanico
                . ", dni_cuenta=" . $this->id_tarea
                . "<br>";
    }
}

?>