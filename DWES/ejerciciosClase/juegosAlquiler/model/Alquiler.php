<?php
require_once 'Conexion.php';

class Alquiler{
    private $id;
    private $Cod_juego;
    private $DNI_cliente;
    private $Fecha_alquiler;
    private $Fecha_devol;
    
    public function __construct($id = 0, $Cod_juego = "", $DNI_cliente = "", $Fecha_alquiler = "", $Fecha_devol = null){
        $this->id = $id;
        $this->Cod_juego = $Cod_juego;
        $this->DNI_cliente = $DNI_cliente;
        $this->Fecha_alquiler = $Fecha_alquiler;
        $this->Fecha_devol = $Fecha_devol;
    }
    
    public function __get(string $name): mixed{
        return $this->$name;
    }
    
    public function __set(string $name, mixed $value): void{
        $this->$name = $value;
    }
    
    // Alquilar juego
    public function alquilar(){
        try{
            $conex = new Conexion();
            $conex->query("INSERT INTO alquiler (Cod_juego, DNI_cliente, Fecha_alquiler, Fecha_devol) VALUES ('$this->Cod_juego', '$this->DNI_cliente', '$this->Fecha_alquiler', NULL)");
            
            // Cambiar estado del juego a alquilado
            $conex->query("UPDATE juegos SET Alguilado='SI' WHERE Codigo='$this->Cod_juego'");
            
            $filas = $conex->affected_rows;
            $conex->close();
            return $filas;
        }catch(Exception $ex){
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
    
    // Devolver juego
    public static function devolver($id){
        try{
            $conex = new Conexion();
            $fecha_actual = date('Y-m-d');
            
            // Obtener código del juego antes de actualizar
            $result = $conex->query("SELECT Cod_juego FROM alquiler WHERE id=$id");
            $reg = $result->fetch_object();
            $cod_juego = $reg->Cod_juego;
            
            // Actualizar fecha de devolución
            $conex->query("UPDATE alquiler SET Fecha_devol='$fecha_actual' WHERE id=$id");
            
            // Cambiar estado del juego a NO alquilado
            $conex->query("UPDATE juegos SET Alguilado='NO' WHERE Codigo='$cod_juego'");
            
            $filas = $conex->affected_rows;
            $conex->close();
            return $filas;
        }catch(Exception $ex){
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
    
    // Obtener alquileres activos de un cliente
    public static function misAlquileres($dni_cliente){
        try{
            $conex = new Conexion();
            $result = $conex->query("SELECT a.*, j.Nombre_juego, j.Imagen 
                                    FROM alquiler a 
                                    INNER JOIN juegos j ON a.Cod_juego = j.Codigo 
                                    WHERE a.DNI_cliente='$dni_cliente' AND a.Fecha_devol IS NULL 
                                    ORDER BY a.Fecha_alquiler DESC");
            
            if($result->num_rows){
                while($fila = $result->fetch_object()){
                    $alquiler = new self($fila->id, $fila->Cod_juego, $fila->DNI_cliente, $fila->Fecha_alquiler, $fila->Fecha_devol);
                    $alquiler->Nombre_juego = $fila->Nombre_juego;
                    $alquiler->Imagen = $fila->Imagen;
                    
                    // Calcular fecha devolución prevista (1 semana)
                    $fecha_alq = new DateTime($fila->Fecha_alquiler);
                    $fecha_alq->add(new DateInterval('P7D'));
                    $alquiler->Fecha_devol_prevista = $fecha_alq->format('Y-m-d');
                    
                    // Calcular recargo por retraso
                    $hoy = new DateTime();
                    if($hoy > $fecha_alq){
                        $diff = $hoy->diff($fecha_alq);
                        $alquiler->Recargo = $diff->days;
                    }else{
                        $alquiler->Recargo = 0;
                    }
                    
                    $alquileres[] = $alquiler;
                }
            }else{
                $alquileres = false;
            }
            
            $conex->close();
            return $alquileres;
        }catch(Exception $ex){
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
    
    // Obtener todos los alquileres activos
    public static function mostrarAlquilados(){
        try{
            $conex = new Conexion();
            $result = $conex->query("SELECT a.*, j.Nombre_juego, c.Nombre, c.Apellidos 
                                    FROM alquiler a 
                                    INNER JOIN juegos j ON a.Cod_juego = j.Codigo 
                                    INNER JOIN cliente c ON a.DNI_cliente = c.DNI 
                                    WHERE a.Fecha_devol IS NULL 
                                    ORDER BY a.Fecha_alquiler DESC");
            
            if($result->num_rows){
                while($fila = $result->fetch_object()){
                    $alquiler = new self($fila->id, $fila->Cod_juego, $fila->DNI_cliente, $fila->Fecha_alquiler, $fila->Fecha_devol);
                    $alquiler->Nombre_juego = $fila->Nombre_juego;
                    $alquiler->Cliente = $fila->Nombre . " " . $fila->Apellidos;
                    $alquileres[] = $alquiler;
                }
            }else{
                $alquileres = false;
            }
            
            $conex->close();
            return $alquileres;
        }catch(Exception $ex){
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
    
    // Verificar si un juego está alquilado y obtener detalles
    public static function detalleAlquiler($cod_juego){
        try{
            $conex = new Conexion();
            $result = $conex->query("SELECT * FROM alquiler WHERE Cod_juego='$cod_juego' AND Fecha_devol IS NULL");
            
            if($result->num_rows){
                $reg = $result->fetch_object();
                $alquiler = new self($reg->id, $reg->Cod_juego, $reg->DNI_cliente, $reg->Fecha_alquiler, $reg->Fecha_devol);
                
                // Calcular fecha devolución prevista
                $fecha_alq = new DateTime($reg->Fecha_alquiler);
                $fecha_alq->add(new DateInterval('P7D'));
                $alquiler->Fecha_devol_prevista = $fecha_alq->format('Y-m-d');
            }else{
                $alquiler = false;
            }
            
            $conex->close();
            return $alquiler;
        }catch(Exception $ex){
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
}
?>