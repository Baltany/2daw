<?php

class Usuario{
    private $id;
    private $nombre;
    private $email;
    private $clave;
    private $telefono;
    private $rol;
    private $fecha_creacion;

    public function esDuenio(): bool {
        return $this->rol === 'dueño';
    }

    public function esVeterinario(): bool {
        return $this->rol === 'veterinario';
    }

    public function __construct($id = 0, $nombre = "", $email = "", $clave = "", $telefono="" ,$rol = "dueño", $fecha_creacion = "") {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->clave = $clave;
        $this->telefono = $telefono;
        $this->rol = $rol;
        $this->fecha_creacion = $fecha_creacion;
    }

    public function __get(string $name): mixed {
        return $this->$name;
    }
    
    public function __set(string $name, mixed $value): void {
        $this->$name=$value;
    }
}




























?>