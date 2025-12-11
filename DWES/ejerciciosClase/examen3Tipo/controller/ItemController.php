<?php
require_once '../model/ConexionPDO.php';
require_once '../model/Item.php';

class ItemController{
    public static function insertar($i){
        try{
            $conex = new ConexionPDO();
            $pdo = $conex->getConexion();
            
            $sql = "INSERT INTO items (nombre, apellidos, provincia, sexo, edad, estado_civil, aficiones, estudios) 
                    VALUES (:nombre, :apellidos, :provincia, :sexo, :edad, :estado_civil, :aficiones, :estudios)";
            
            $stmt = $pdo->prepare($sql);
            
            // Usar execute() con array en lugar de bindParam()
            $resultado = $stmt->execute([
                ':nombre' => $i->nombre,
                ':apellidos' => $i->apellidos,
                ':provincia' => $i->provincia,
                ':sexo' => $i->sexo,
                ':edad' => $i->edad,
                ':estado_civil' => $i->estado_civil,
                ':aficiones' => $i->aficiones,
                ':estudios' => $i->estudios
            ]);
            
            return $resultado ? $stmt->rowCount() : 0;
        } catch (PDOException $ex) {
            echo "<a href='../view/crear_item.php'>Ir a crear item</a>";
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
    
    public static function buscar($id){
        try{
            $conex = new ConexionPDO();
            $pdo = $conex->getConexion();
            
            $sql = "SELECT * FROM items WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            
            if($stmt->rowCount()){
                $reg = $stmt->fetch(PDO::FETCH_OBJ);
                $i = new Item(
                    $reg->id,
                    $reg->nombre,
                    $reg->apellidos,
                    $reg->provincia,
                    $reg->sexo,
                    $reg->edad,
                    $reg->estado_civil,
                    $reg->aficiones,
                    $reg->estudios,
                    $reg->fecha_creacion
                );
            } else {
                $i = false;
            }
            return $i;
        } catch (PDOException $ex) {
            echo "<a href='../view/items.php'>Ir a items</a>";
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
    
    public static function mostrar(){
        try{
            $conex = new ConexionPDO();
            $pdo = $conex->getConexion();
            
            $sql = "SELECT * FROM items ORDER BY id DESC";
            $stmt = $pdo->query($sql);
            
            $items = array();
            if($stmt->rowCount()){
                while($fila = $stmt->fetch(PDO::FETCH_OBJ)){
                    $i = new Item(
                        $fila->id,
                        $fila->nombre,
                        $fila->apellidos,
                        $fila->provincia,
                        $fila->sexo,
                        $fila->edad,
                        $fila->estado_civil,
                        $fila->aficiones,
                        $fila->estudios,
                        $fila->fecha_creacion
                    );
                    $items[] = $i;
                }
            } else {
                $items = false;
            }
            return $items;            
        } catch (PDOException $ex) {
            echo "<a href='../view/items.php'>Ir a items</a>";
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
    
    public static function actualizar($i){
        try{
            $conex = new ConexionPDO();
            $pdo = $conex->getConexion();
            
            $sql = "UPDATE items SET 
                    nombre = :nombre,
                    apellidos = :apellidos,
                    provincia = :provincia,
                    sexo = :sexo,
                    edad = :edad,
                    estado_civil = :estado_civil,
                    aficiones = :aficiones,
                    estudios = :estudios 
                    WHERE id = :id";
            
            $stmt = $pdo->prepare($sql);
            
            // Usar execute() con array en lugar de bindParam()
            $resultado = $stmt->execute([
                ':nombre' => $i->nombre,
                ':apellidos' => $i->apellidos,
                ':provincia' => $i->provincia,
                ':sexo' => $i->sexo,
                ':edad' => $i->edad,
                ':estado_civil' => $i->estado_civil,
                ':aficiones' => $i->aficiones,
                ':estudios' => $i->estudios,
                ':id' => $i->id
            ]);
            
            return $resultado ? $stmt->rowCount() : 0;
        } catch (PDOException $ex) {
            echo "<a href='../view/items.php'>Ir a items</a>";
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
    
    public static function eliminar($id){
        try{
            $conex = new ConexionPDO();
            $pdo = $conex->getConexion();
            
            $sql = "DELETE FROM items WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            
            return $stmt->rowCount();
        } catch (PDOException $ex) {
            echo "<a href='../view/items.php'>Ir a items</a>";
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
}
?>