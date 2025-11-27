<?php
require_once 'Conexion.php';
class Producto{
    private $codigo;
    private $nombre;
    private $precio;
    
    public function __construct($codigo=0,$nombre="",$precio=0){
        $this->codigo=$codigo;
        $this->nombre=$nombre;
        $this->precio=$precio;
    }

    public function nuevoProducto($codigo,$nombre,$precio){
        $this->codigo=$codigo;
        $this->nombre=$nombre;
        $this->precio=$precio;
    }

    public function insertar(){
        try{
            $conex = new Conexion();
            $conex -> query("INSERT INTO producto VALUES($this->codigo,'$this->nombre',$this->precio)");
            $filas = $conex -> affected_rows;
            $conex->close();
            return $filas;
        }catch(mysqli_sql_exception $e){
            echo $e->getMessage();

        }
    }

    public static function buscar($codigo){
        try{
            $conex = new Conexion();
            $result = $conex->query("SELECT * FROM  producto WHERE codigo=$codigo");
            if($result ->num_rows){
                $reg=$result->fetch_object();
            }
        }catch(mysqli_sql_exception $e){
            echo $e->getMessage();
        }
    }

    // no hace falta tiparlo
    public function __toString()
    {
        
    }
}


?>