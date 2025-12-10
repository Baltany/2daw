<?php
require_once 'Conexion.php';

class EntidadPrincipal{ // ⬅️ CAMBIAR nombre (Coche, Juego, Libro...)
    private $id;
    private $campo1;
    private $campo2;
    private $campo3;
    // ... ⬅️ AÑADIR campos según tu tabla
    
    public function __construct($id = 0, $campo1 = "", $campo2 = "", $campo3 = ""){
        $this->id = $id;
        $this->campo1 = $campo1;
        $this->campo2 = $campo2;
        $this->campo3 = $campo3;
    }
    
    // ========== GETTERS/SETTERS ==========
    public function __get(string $name): mixed{
        return $this->$name;
    }
    
    public function __set(string $name, mixed $value): void{
        $this->$name = $value;
    }
    
    // ========== INSERTAR ==========
    public function insertar(){
        try{
            $conex = new Conexion();
            // ⬅️ CAMBIAR query según tu tabla
            $stmt = $conex->prepare("INSERT INTO tabla (campo1, campo2, campo3) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $this->campo1, $this->campo2, $this->campo3);
            $stmt->execute();
            $filas = $stmt->affected_rows;
            $stmt->close();
            $conex->close();
            return $filas;
        }catch(Exception $ex){
            die("ERROR BD: " . $ex->getMessage());
        }
    }
    
    // ========== ACTUALIZAR ==========
    public function actualizar(){
        try{
            $conex = new Conexion();
            // ⬅️ CAMBIAR query
            $stmt = $conex->prepare("UPDATE tabla SET campo1=?, campo2=?, campo3=? WHERE id=?");
            $stmt->bind_param("sssi", $this->campo1, $this->campo2, $this->campo3, $this->id);
            $stmt->execute();
            $filas = $stmt->affected_rows;
            $stmt->close();
            $conex->close();
            return $filas;
        }catch(Exception $ex){
            die("ERROR BD: " . $ex->getMessage());
        }
    }
    
    // ========== ELIMINAR ==========
    public static function eliminar($id){
        try{
            $conex = new Conexion();
            $stmt = $conex->prepare("DELETE FROM tabla WHERE id=?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $filas = $stmt->affected_rows;
            $stmt->close();
            $conex->close();
            return $filas;
        }catch(Exception $ex){
            die("ERROR BD: " . $ex->getMessage());
        }
    }
    
    // ========== BUSCAR POR ID ==========
    public static function buscar($id){
        try{
            $conex = new Conexion();
            $stmt = $conex->prepare("SELECT * FROM tabla WHERE id=?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if($result->num_rows){
                $reg = $result->fetch_object();
                $objeto = new self($reg->id, $reg->campo1, $reg->campo2, $reg->campo3);
            }else{
                $objeto = null;
            }
            
            $stmt->close();
            $conex->close();
            return $objeto;
        }catch(Exception $ex){
            die("ERROR BD: " . $ex->getMessage());
        }
    }
    
    // ========== LISTAR TODOS ==========
    public static function listarTodos(){
        try{
            $conex = new Conexion();
            $result = $conex->query("SELECT * FROM tabla ORDER BY campo1");
            
            $lista = [];
            if($result->num_rows){
                while($fila = $result->fetch_object()){
                    $lista[] = new self($fila->id, $fila->campo1, $fila->campo2, $fila->campo3);
                }
            }
            
            $conex->close();
            return $lista ?: null;
        }catch(Exception $ex){
            die("ERROR BD: " . $ex->getMessage());
        }
    }
}
?>