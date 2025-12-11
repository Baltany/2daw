<?php
// modelos/Usuario.php
require_once 'Conexion.php';

class Usuario{
    private $id;
    private $nombre;
    private $email;
    private $pass;
    private $tipo; // 'admin' o 'cliente'
    
    public function __construct($id = 0, $nombre = "", $email = "", $pass = "", $tipo = "cliente"){
        $this->id = $id;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->pass = $pass;
        $this->tipo = $tipo;
    }
    
    public function __get(string $name): mixed{
        return $this->$name;
    }
    
    public function __set(string $name, mixed $value): void{
        $this->$name = $value;
    }
    
    public function __toString(): string{
        return $this->nombre;
    }
    
    // ==========================================
    // LOGIN CON MD5
    // ==========================================
    public static function login($email, $pass){
        try{
            $conex = new Conexion();
            $pass_hash = md5($pass);
            $result = $conex->query("SELECT * FROM usuarios WHERE email='$email' AND pass='$pass_hash'");
            
            if($result->num_rows){
                $reg = $result->fetch_object();
                $usuario = new Usuario($reg->id, $reg->nombre, $reg->email, $reg->pass, $reg->tipo);
            }else{
                $usuario = false;
            }
            
            $conex->close();
            return $usuario;
        }catch(Exception $ex){
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
    
    // ==========================================
    // LOGIN CON BCRYPT (COMENTADO)
    // ==========================================
    /*
    public static function loginBcrypt($email, $pass){
        try{
            $conex = new Conexion();
            // Primero obtener el usuario por email
            $result = $conex->query("SELECT * FROM usuarios WHERE email='$email'");
            
            if($result->num_rows){
                $reg = $result->fetch_object();
                // Verificar contraseña con password_verify
                if(password_verify($pass, $reg->pass)){
                    $usuario = new Usuario($reg->id, $reg->nombre, $reg->email, $reg->pass, $reg->tipo);
                }else{
                    $usuario = false;
                }
            }else{
                $usuario = false;
            }
            
            $conex->close();
            return $usuario;
        }catch(Exception $ex){
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
    */
    
    // ==========================================
    // INSERTAR (REGISTRAR)
    // ==========================================
    public function insertar(){
        try{
            $conex = new Conexion();
            $conex->query("INSERT INTO usuarios (nombre, email, pass, tipo) 
                          VALUES ('$this->nombre', '$this->email', '$this->pass', '$this->tipo')");
            $filas = $conex->affected_rows;
            $conex->close();
            return $filas;
        }catch(Exception $ex){
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
    
    // ==========================================
    // BUSCAR POR ID
    // ==========================================
    public static function buscar($id){
        try{
            $conex = new Conexion();
            $result = $conex->query("SELECT * FROM usuarios WHERE id=$id");
            
            if($result->num_rows){
                $reg = $result->fetch_object();
                $usuario = new Usuario($reg->id, $reg->nombre, $reg->email, $reg->pass, $reg->tipo);
            }else{
                $usuario = false;
            }
            
            $conex->close();
            return $usuario;
        }catch(Exception $ex){
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
    
    // ==========================================
    // MOSTRAR TODOS
    // ==========================================
    public static function mostrar(){
        try{
            $conex = new Conexion();
            $result = $conex->query("SELECT * FROM usuarios ORDER BY nombre");
            
            if($result->num_rows){
                while($fila = $result->fetch_object()){
                    $usuario = new self($fila->id, $fila->nombre, $fila->email, $fila->pass, $fila->tipo);
                    $usuarios[] = $usuario;
                }
            }else{
                $usuarios = false;
            }
            
            $conex->close();
            return $usuarios;
        }catch(Exception $ex){
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
    
    // ==========================================
    // ACTUALIZAR
    // ==========================================
    public function actualizar(){
        try{
            $conex = new Conexion();
            $conex->query("UPDATE usuarios SET nombre='$this->nombre', email='$this->email', tipo='$this->tipo' 
                          WHERE id=$this->id");
            $filas = $conex->affected_rows;
            $conex->close();
            return $filas;
        }catch(Exception $ex){
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
    
    // ==========================================
    // ELIMINAR
    // ==========================================
    public static function eliminar($id){
        try{
            $conex = new Conexion();
            $conex->query("DELETE FROM usuarios WHERE id=$id");
            $filas = $conex->affected_rows;
            $conex->close();
            return $filas;
        }catch(Exception $ex){
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
}
?>