<?php
require_once 'Conexion.php';

class Cliente{
    private $DNI;
    private $Nombre;
    private $Apellidos;
    private $Direccion;
    private $Localidad;
    private $Clave;
    private $Tipo;
    
    public function __construct($DNI = "", $Nombre = "", $Apellidos = "", $Direccion = "", $Localidad = "", $Clave = "", $Tipo = "cliente"){
        $this->DNI = $DNI;
        $this->Nombre = $Nombre;
        $this->Apellidos = $Apellidos;
        $this->Direccion = $Direccion;
        $this->Localidad = $Localidad;
        $this->Clave = $Clave;
        $this->Tipo = $Tipo;
    }
    
    public function __get(string $name): mixed{
        return $this->$name;
    }
    
    public function __set(string $name, mixed $value): void{
        $this->$name = $value;
    }
    
    public function __toString(): string{
        return $this->Nombre . " " . $this->Apellidos;
    }
    
    // Login con MD5
    public static function login($dni, $clave){
        try{
            $conex = new Conexion();
            $clave_hash = md5($clave); // MD5 (como el profesor)
            // Para usar bcrypt en lugar de MD5:
            // Al registrar: $clave_hash = password_hash($clave, PASSWORD_DEFAULT);
            // Al login: usar password_verify($clave, $usuario->Clave) en lugar de comparar directamente
            
            $result = $conex->query("SELECT * FROM cliente WHERE DNI='$dni' AND Clave='$clave_hash'");
            
            if($result->num_rows){
                $reg = $result->fetch_object();
                $cliente = new Cliente($reg->DNI, $reg->Nombre, $reg->Apellidos, $reg->Direccion, $reg->Localidad, $reg->Clave, $reg->Tipo);
            }else{
                $cliente = false;
            }
            
            $conex->close();
            return $cliente;
        }catch(Exception $ex){
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
}
?>