<?php
require_once 'Conexion.php';

class Usuario{
    private $DNI;      // ⬅️ CAMBIAR según tu tabla (id, email, etc)
    private $Nombre;
    private $Apellidos;
    private $Clave;
    private $Tipo;     // 'admin' o 'cliente'
    
    public function __construct($DNI = "", $Nombre = "", $Apellidos = "", $Clave = "", $Tipo = "cliente"){
        $this->DNI = $DNI;
        $this->Nombre = $Nombre;
        $this->Apellidos = $Apellidos;
        $this->Clave = $Clave;
        $this->Tipo = $Tipo;
    }
    
    // ========== GETTERS/SETTERS ==========
    public function __get(string $name): mixed{
        return $this->$name;
    }
    
    public function __set(string $name, mixed $value): void{
        $this->$name = $value;
    }
    
    public function __toString(): string{
        return $this->Nombre . " " . $this->Apellidos;
    }
    
    // ========== LOGIN CON CONTROL DE INTENTOS ==========
    public static function login($identificador, $clave){
        // Control de intentos fallidos
        if(!isset($_SESSION['intentos_login'])){
            $_SESSION['intentos_login'] = 0;
            $_SESSION['tiempo_bloqueo'] = null;
        }
        
        // Verificar si está bloqueado
        if($_SESSION['intentos_login'] >= 3){
            if($_SESSION['tiempo_bloqueo'] === null){
                $_SESSION['tiempo_bloqueo'] = time();
            }
            
            $tiempo_transcurrido = time() - $_SESSION['tiempo_bloqueo'];
            $tiempo_bloqueo = 300; // 5 minutos (300 segundos)
            
            if($tiempo_transcurrido < $tiempo_bloqueo){
                $tiempo_restante = $tiempo_bloqueo - $tiempo_transcurrido;
                $minutos = floor($tiempo_restante / 60);
                $segundos = $tiempo_restante % 60;
                return "CUENTA BLOQUEADA. Espere {$minutos}m {$segundos}s";
            }else{
                // Desbloquear después de 5 minutos
                $_SESSION['intentos_login'] = 0;
                $_SESSION['tiempo_bloqueo'] = null;
            }
        }
        
        try{
            $conex = new Conexion();
            $clave_hash = md5($clave);
            
            // ⬅️ CAMBIAR nombres de tabla y campos
            $stmt = $conex->prepare("SELECT * FROM usuario WHERE DNI=? AND Clave=?");
            $stmt->bind_param("ss", $identificador, $clave_hash);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if($result->num_rows){
                // Login exitoso
                $_SESSION['intentos_login'] = 0;
                $_SESSION['tiempo_bloqueo'] = null;
                
                $reg = $result->fetch_object();
                $usuario = new Usuario($reg->DNI, $reg->Nombre, $reg->Apellidos, $reg->Clave, $reg->Tipo);
                
                $stmt->close();
                $conex->close();
                return $usuario;
            }else{
                // Login fallido
                $_SESSION['intentos_login']++;
                $intentos_restantes = 3 - $_SESSION['intentos_login'];
                
                $stmt->close();
                $conex->close();
                
                if($intentos_restantes > 0){
                    return "Credenciales incorrectas. Intentos restantes: {$intentos_restantes}";
                }else{
                    $_SESSION['tiempo_bloqueo'] = time();
                    return "CUENTA BLOQUEADA por 5 minutos";
                }
            }
        }catch(Exception $ex){
            die("ERROR BD: " . $ex->getMessage());
        }
    }
}
?>