<?php
require_once '../model/Conexion.php';
require_once '../model/Cuenta.php';

class CuentaController{
    public static function insertar($i){
        try{
            $conex=new Conexion();
            $conex->query("INSERT INTO cuentas (nombre,apellidos,provincia,sexo,edad,estado_civil,aficiones,estudios) VALUES ('$i->nombre','$i->apellidos','$i->provincia','$i->sexo','$i->edad','$i->estado_civil','$i->aficiones','$i->estudios')");
            $filas=$conex->affected_rows;
            $conex->close();
            return $filas;
        } catch (Exception $ex) {
            echo "<a href=../view/crear_cuenta.php>Ir a crear cuenta</a>";
            die("ERROR CON LA BD: ".$ex->getMessage());
        }
    }
    
    public static function buscar($id){
        try{
            $conex=new Conexion();
            $result=$conex->query("SELECT * FROM cuentas WHERE id=$id");
            if($result->num_rows){
                $reg=$result->fetch_object();
                $i=new Cuenta($reg->id,$reg->nombre,$reg->apellidos,$reg->provincia,$reg->sexo,$reg->edad,$reg->estado_civil,$reg->aficiones,$reg->estudios,$reg->fecha_creacion);
            }
            else
                $i=false;
            $conex->close();
            return $i;
        } catch (Exception $ex) {
            echo "<a href=../view/cuentas.php>Ir a cuentas</a>";
            die("ERROR CON LA BD: ".$ex->getMessage());
        }
    }
    
    public static function mostrar(){
        try{
            $conex=new Conexion();
            $result=$conex->query("SELECT * FROM cuentas ORDER BY id DESC");
            if($result->num_rows){
                while($fila=$result->fetch_object()){
                    $i=new Cuenta($fila->id,$fila->nombre,$fila->apellidos,$fila->provincia,$fila->sexo,$fila->edad,$fila->estado_civil,$fila->aficiones,$fila->estudios,$fila->fecha_creacion);
                    $cuentas[]=$i;
                }
            }
            else $cuentas=false;
            $conex->close();
            return $cuentas;            
        } catch (Exception $ex) {
            echo "<a href=../view/cuentas.php>Ir a cuentas</a>";
            die("ERROR CON LA BD: ".$ex->getMessage());
        }
    }
    
    public static function actualizar($i){
        try{
            $conex=new Conexion();
            $conex->query("UPDATE cuentas SET nombre='$i->nombre',apellidos='$i->apellidos',provincia='$i->provincia',sexo='$i->sexo',edad='$i->edad',estado_civil='$i->estado_civil',aficiones='$i->aficiones',estudios='$i->estudios' WHERE id=$i->id");
            $filas=$conex->affected_rows;
            $conex->close();
            return $filas;
        } catch (Exception $ex) {
            echo "<a href=../view/cuentas.php>Ir a cuentas</a>";
            die("ERROR CON LA BD: ".$ex->getMessage());
        }
    }
    
    public static function eliminar($id){
        try{
            $conex=new Conexion();
            $conex->query("DELETE FROM cuentas WHERE id=$id");
            $filas=$conex->affected_rows;
            $conex->close();
            return $filas;
        } catch (Exception $ex) {
            echo "<a href=../view/cuentas.php>Ir a cuentas</a>";
            die("ERROR CON LA BD: ".$ex->getMessage());
        }
    }

    public static function obtenerPorDni($dni){
        try{
            $conex=new Conexion();
            $result=$conex->query("SELECT * FROM cuentas WHERE dni_cuenta='$dni'");
            $cuentas = [];
            if($result->num_rows){
                while($reg = $result->fetch_object()){
                    $c = new Cuenta(
                        $reg->iban,
                        $reg->saldo,
                        $reg->dni_cuenta
                    );
                    $cuentas[] = $c;
                }
            } else {
                $cuentas = false;
            }
            $conex->close();
            return $cuentas;
        } catch (Exception $ex) {
            die("ERROR CON LA BD: ".$ex->getMessage());
        }
    }

public static function obtenerPorIban($iban){
    try{
        $conex = new Conexion();
        $result = $conex->query("SELECT * FROM cuentas WHERE iban='$iban'");
        
        if($result->num_rows){
            $reg = $result->fetch_object();
            $c = new Cuenta(
                $reg->iban,
                $reg->saldo,
                $reg->dni_cuenta
            );
            $conex->close();
            return $c; 
        } else {
            $conex->close();
            return false;
        }
    } catch (Exception $ex) {
        die("ERROR CON LA BD: ".$ex->getMessage());
    }
}

public static function realizarTransferenciaConTransaccion($ibanOrigen, $ibanDestino, $cantidad) {
    $conex = new Conexion();
    
    try {
        // 1. INICIAR TRANSACCIÓN (Desactivar autoguardado)
        $conex->autocommit(false); 

        // ---------------------------------------------------------
        // PASO A: Descontar dinero del origen
        // ---------------------------------------------------------
        $sqlDescontar = "UPDATE cuentas SET saldo = saldo - $cantidad WHERE iban = '$ibanOrigen'";
        if (!$conex->query($sqlDescontar)) {
            throw new Exception("Error al descontar saldo");
        }
        
        // Verificamos que realmente se haya tocado alguna fila (que el IBAN exista)
        if ($conex->affected_rows == 0) {
            throw new Exception("No se encontró la cuenta de origen o saldo insuficiente.");
        }

        // ---------------------------------------------------------
        // PASO B: Sumar dinero al destino
        // ---------------------------------------------------------
        $sqlSumar = "UPDATE cuentas SET saldo = saldo + $cantidad WHERE iban = '$ibanDestino'";
        if (!$conex->query($sqlSumar)) {
            throw new Exception("Error al sumar saldo al destino");
        }

        // ---------------------------------------------------------
        // PASO C: Registrar el movimiento en la tabla transferencias
        // ---------------------------------------------------------
        $fechaActual = time(); // Tu tabla usa INT para la fecha (Timestamp)
        $sqlHistorial = "INSERT INTO transferencias (iban_origen, iban_destino, fecha, cantidad) 
                         VALUES ('$ibanOrigen', '$ibanDestino', $fechaActual, $cantidad)";
        
        if (!$conex->query($sqlHistorial)) {
            throw new Exception("Error al guardar historial");
        }

        // ---------------------------------------------------------
        // SI LLEGAMOS AQUÍ, TODO FUE BIEN -> CONFIRMAR CAMBIOS
        // ---------------------------------------------------------
        $conex->commit();
        $conex->close();
        return true; // Éxito

    } catch (Exception $e) {
        // SI ALGO FALLÓ -> DESHACER TODO
        $conex->rollback();
        $conex->close();
        return "Fallo: " . $e->getMessage(); // Devolvemos el error
    }
}

public static function realizarTransferenciaSinTransaccion($ibanOrigen, $ibanDestino, $cantidad) {
    $conex = new Conexion();

    // PASO A: Descontar
    $sqlDescontar = "UPDATE cuentas SET saldo = saldo - $cantidad WHERE iban = '$ibanOrigen'";
    $conex->query($sqlDescontar);

    // PASO B: Sumar (Si esto falla, el dinero del paso A ya se perdió)
    $sqlSumar = "UPDATE cuentas SET saldo = saldo + $cantidad WHERE iban = '$ibanDestino'";
    $conex->query($sqlSumar);

    // PASO C: Insertar Historial
    $fechaActual = time();
    $sqlHistorial = "INSERT INTO transferencias (iban_origen, iban_destino, fecha, cantidad) 
                     VALUES ('$ibanOrigen', '$ibanDestino', $fechaActual, $cantidad)";
    $conex->query($sqlHistorial);

    $conex->close();
    return true;
}

public static function obtenerOtrasCuentas($miIban){
        try{
            $conex = new Conexion();
            
            // Hacemos una consulta uniendo cuentas y usuarios
            // Queremos todas las cuentas MENOS la mía (WHERE c.iban != '$miIban')
            $sql = "SELECT c.*, u.Nombre 
                    FROM cuentas c 
                    JOIN usuarios u ON c.dni_cuenta = u.DNI 
                    WHERE c.iban != '$miIban'";
            
            $result = $conex->query($sql);
            $cuentas = [];
            
            if($result->num_rows){
                while($reg = $result->fetch_object()){
                    // Creamos el objeto Cuenta normal
                    $c = new Cuenta(
                        $reg->iban,
                        $reg->saldo,
                        $reg->dni_cuenta
                    );
                    
                    // TRUCO: Añadimos una propiedad "extra" al objeto
                    // para guardar el nombre del dueño y mostrarlo en el HTML
                    $c->nombre_propietario = $reg->Nombre; 
                    
                    $cuentas[] = $c;
                }
            }
            $conex->close();
            return $cuentas;
            
        } catch (Exception $ex) {
            die("ERROR CON LA BD: ".$ex->getMessage());
        }
    }

    
}
?>