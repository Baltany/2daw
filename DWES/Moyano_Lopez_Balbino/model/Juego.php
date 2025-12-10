<?php
require_once 'Conexion.php';

class Juego{
    private $Codigo;
    private $Nombre_juego;
    private $Nombre_consola;
    private $Anno;
    private $Precio;
    private $Alguilado;
    private $Imagen;
    private $descripcion;
    
    public function __construct($Codigo = "", $Nombre_juego = "", $Nombre_consola = "", $Anno = 0, $Precio = 0, $Alguilado = "NO", $Imagen = "", $descripcion = ""){
        $this->Codigo = $Codigo;
        $this->Nombre_juego = $Nombre_juego;
        $this->Nombre_consola = $Nombre_consola;
        $this->Anno = $Anno;
        $this->Precio = $Precio;
        $this->Alguilado = $Alguilado;
        $this->Imagen = $Imagen;
        $this->descripcion = $descripcion;
    }
    
    public function __get(string $name): mixed{
        return $this->$name;
    }
    
    public function __set(string $name, mixed $value): void{
        $this->$name = $value;
    }
    
    public function __toString(): string{
        return $this->Nombre_juego . " - " . $this->Nombre_consola;
    }
    
    // Insertar juego
    public function insertar(){
        try{
            $conex = new Conexion();
            $conex->query("INSERT INTO juegos VALUES ('$this->Codigo', '$this->Nombre_juego', '$this->Nombre_consola', $this->Anno, $this->Precio, '$this->Alguilado', '$this->Imagen', '$this->descripcion')");
            $filas = $conex->affected_rows;
            $conex->close();
            return $filas;
        }catch(Exception $ex){
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
    
    // Actualizar juego
    public function actualizar(){
        try{
            $conex = new Conexion();
            $conex->query("UPDATE juegos SET Nombre_juego='$this->Nombre_juego', Nombre_consola='$this->Nombre_consola', Anno=$this->Anno, Precio=$this->Precio, Alguilado='$this->Alguilado', Imagen='$this->Imagen', descripcion='$this->descripcion' WHERE Codigo='$this->Codigo'");
            $filas = $conex->affected_rows;
            $conex->close();
            return $filas;
        }catch(Exception $ex){
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
    
    // Eliminar juego
    public static function eliminar($codigo){
        try{
            $conex = new Conexion();
            $conex->query("DELETE FROM juegos WHERE Codigo='$codigo'");
            $filas = $conex->affected_rows;
            $conex->close();
            return $filas;
        }catch(Exception $ex){
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
    
    // Buscar juego por código
    public static function buscar($codigo){
        try{
            $conex = new Conexion();
            $result = $conex->query("SELECT * FROM juegos WHERE Codigo='$codigo'");
            
            if($result->num_rows){
                $reg = $result->fetch_object();
                $juego = new Juego($reg->Codigo, $reg->Nombre_juego, $reg->Nombre_consola, $reg->Anno, $reg->Precio, $reg->Alguilado, $reg->Imagen, $reg->descripcion);
            }else{
                $juego = false;
            }
            
            $conex->close();
            return $juego;
        }catch(Exception $ex){
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
    
    // Mostrar todos los juegos
    public static function mostrar(){
        try{
            $conex = new Conexion();
            $result = $conex->query("SELECT * FROM juegos ORDER BY Nombre_juego");
            
            if($result->num_rows){
                while($fila = $result->fetch_object()){
                    $juego = new self($fila->Codigo, $fila->Nombre_juego, $fila->Nombre_consola, $fila->Anno, $fila->Precio, $fila->Alguilado, $fila->Imagen, $fila->descripcion);
                    $juegos[] = $juego;
                }
            }else{
                $juegos = false;
            }
            
            $conex->close();
            return $juegos;
        }catch(Exception $ex){
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
    
    // Mostrar juegos alquilados
    public static function mostrarAlquilados(){
        try{
            $conex = new Conexion();
            $result = $conex->query("SELECT * FROM juegos WHERE Alguilado='SI' ORDER BY Nombre_juego");
            
            if($result->num_rows){
                while($fila = $result->fetch_object()){
                    $juego = new self($fila->Codigo, $fila->Nombre_juego, $fila->Nombre_consola, $fila->Anno, $fila->Precio, $fila->Alguilado, $fila->Imagen, $fila->descripcion);
                    $juegos[] = $juego;
                }
            }else{
                $juegos = false;
            }
            
            $conex->close();
            return $juegos;
        }catch(Exception $ex){
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
    
    // Mostrar juegos NO alquilados
    public static function mostrarNoAlquilados(){
        try{
            $conex = new Conexion();
            $result = $conex->query("SELECT * FROM juegos WHERE Alguilado='NO' ORDER BY Nombre_juego");
            
            if($result->num_rows){
                while($fila = $result->fetch_object()){
                    $juego = new self($fila->Codigo, $fila->Nombre_juego, $fila->Nombre_consola, $fila->Anno, $fila->Precio, $fila->Alguilado, $fila->Imagen, $fila->descripcion);
                    $juegos[] = $juego;
                }
            }else{
                $juegos = false;
            }
            
            $conex->close();
            return $juegos;
        }catch(Exception $ex){
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
}
?>