<?php
// ==========================================
// EJEMPLO CON TRANSACCIONES
// ==========================================
public static function alquilarConTransaccion($cod_juego, $dni_cliente){
    try{
        $conex = new Conexion();
        $conex->autocommit(false); // Desactivar autocommit
        
        // Primera operación: Insertar alquiler
        $fecha = date('Y-m-d');
        $stmt = $conex->prepare("INSERT INTO alquiler (cod_juego, dni_cliente, fecha_alquiler) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $cod_juego, $dni_cliente, $fecha);
        $stmt->execute();
        
        if($stmt->affected_rows){
            // Segunda operación: Actualizar estado del juego
            $conex->query("UPDATE juegos SET alquilado='SI' WHERE codigo='$cod_juego'");
            
            if($conex->affected_rows){
                $conex->commit(); // Confirmar transacción
                return true;
            }else{
                $conex->rollback(); // Revertir cambios
                return false;
            }
        }else{
            $conex->rollback();
            return false;
        }
        
    }catch(Exception $ex){
        $conex->rollback();
        die("ERROR: " . $ex->getMessage());
    }
}
?>


<!-- SIN TRANSACCIONES -->
 <?php
// ==========================================
// EJEMPLO SIN TRANSACCIONES
// ==========================================
public static function alquilarSinTransaccion($cod_juego, $dni_cliente){
    try{
        $conex = new Conexion();
        
        // Primera operación
        $fecha = date('Y-m-d');
        $stmt = $conex->prepare("INSERT INTO alquiler (cod_juego, dni_cliente, fecha_alquiler) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $cod_juego, $dni_cliente, $fecha);
        $stmt->execute();
        
        if($stmt->affected_rows){
            // Segunda operación
            $conex->query("UPDATE juegos SET alquilado='SI' WHERE codigo='$cod_juego'");
            
            if($conex->affected_rows){
                return true;
            }
        }
        
        return false;
        
    }catch(Exception $ex){
        die("ERROR: " . $ex->getMessage());
    }
}

// SUBIR IMAGENES
if($_FILES['foto']['error'] == 0) {
    $extension = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
    
    if($extension == 'jpg') {
        $nombre = time() . "_" . $variable . ".jpg";
        $ruta = "../../imagenes/" . $nombre;
        move_uploaded_file($_FILES['foto']['tmp_name'], $ruta);
    }
}
?>