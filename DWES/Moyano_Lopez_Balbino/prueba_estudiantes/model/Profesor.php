<?php
class Profesor{

    private $codigo;
    private $usuario;
    private $clave;
    private $nombrecompleto;
    
    private $email;
    
    private $telf;
    private $rol;
    
    private $intentos_fallidos;

    private $bloqueo_hasta;
    
    private $ultimo_acceso;


    public function esAdmin(): bool {
        return $this->rol === 'admin';
    }

    public function esProfesor(): bool {
        return $this->rol === 'profesor';
    }

    public function esTutor(): bool {
        return $this->rol === 'tutor_academico';
    }


    public function __construct($codigo = 0, $usuario = "", $nombrecompleto = "",$email="", $clave = "",$telf="", $rol = "",$intentos_fallidos = 0,$bloqueo_hasta = "", $ultimo_acceso = "") {
        $this->codigo = $codigo;
        $this->usuario = $usuario;
        $this->nombrecompleto = $nombrecompleto;
        $this->email = $email;
        $this->clave = $clave;
        $this->telf = $telf;
        $this->rol = $rol;
        $this->intentos_fallidos = $intentos_fallidos;
        $this->bloqueo_hasta = $bloqueo_hasta;
        $this->ultimo_acceso = $ultimo_acceso;
    }

    public function __get(string $name): mixed {
        return $this->$name;
    }
    
    public function __set(string $name, mixed $value): void {
        $this->$name=$value;
    }


}
?>