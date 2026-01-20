<?php
class Usuario{
    private $id;
    private $nombre;
    private $email;
    private $clave;
    private $rol;
    private $fecha_creacion;


    public function esAdmin(): bool {
        return $this->rol === 'admin';
    }

    public function esUsuario(): bool {
        return $this->rol === 'usuario';
    }

    public function __construct($id = 0, $nombre = "", $email = "", $clave = "", $rol = "usuario", $fecha_creacion = "") {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->clave = $clave;
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