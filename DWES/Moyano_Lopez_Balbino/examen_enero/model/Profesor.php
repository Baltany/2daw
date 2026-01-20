<?php
class Profesor{

    private $dni_p;
    private $nombre;
    private $apellidos;
    private $pass;
    
    private $bloqueado;
    
    private $hora_bloqueo;
    private $intentos;
    


    public function __construct($dni_p = "", $nombre = "", $pass = "",$bloqueado="", $apellidos = "",$hora_bloqueo="", $intentos = "",$intentos_fallidos = 0,$bloqueo_hasta = "", $ultimo_acceso = "") {
        $this->dni_p = $dni_p;
        $this->nombre = $nombre;
        $this->pass = $pass;
        $this->bloqueado = $bloqueado;
        $this->apellidos = $apellidos;
        $this->hora_bloqueo = $hora_bloqueo;
        $this->intentos = $intentos;

    }

    public function __get(string $name): mixed {
        return $this->$name;
    }
    
    public function __set(string $name, mixed $value): void {
        $this->$name=$value;
    }


}
?>