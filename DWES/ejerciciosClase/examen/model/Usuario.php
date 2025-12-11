<?php
class Usuario{
    private $id;
    private $dni;
    private $nombre;
    private $apellidos;
    private $email;
    private $password;
    private $provincia;
    private $sexo;
    private $edad;
    private $estado_civil;
    private $aficiones;
    private $estudios;
    private $fecha_registro;
    
    public function __construct($id=0,$dni="",$nombre="",$apellidos="",$email="",$password="",$provincia="",$sexo="",$edad=0,$estado_civil="",$aficiones="",$estudios="",$fecha_registro="") {
        $this->id=$id;
        $this->dni=$dni;
        $this->nombre=$nombre;
        $this->apellidos=$apellidos;
        $this->email=$email;
        $this->password=$password;
        $this->provincia=$provincia;
        $this->sexo=$sexo;
        $this->edad=$edad;
        $this->estado_civil=$estado_civil;
        $this->aficiones=$aficiones;
        $this->estudios=$estudios;
        $this->fecha_registro=$fecha_registro;
    }
    
    public function __get(string $name): mixed {
        return $this->$name;
    }
    
    public function __set(string $name, mixed $value): void {
        $this->$name=$value;
    }
    
    public function __toString(): string {
        return "<br>Usuario[dni=" . $this->dni
                . ", nombre=" . $this->nombre
                . ", apellidos=" . $this->apellidos
                . ", email=" . $this->email
                . "]<br>";
    }
}
?>