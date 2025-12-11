<?php
require_once '../model/ConexionPDO.php';
require_once '../model/Usuario.php';

class UsuarioController{
    public static function insertar($u){
        try{
            $conex = new ConexionPDO();
            $pdo = $conex->getConexion();
            
            $sql = "INSERT INTO usuarios (dni, nombre, apellidos, email, password, provincia, sexo, edad, estado_civil, aficiones, estudios, tipo) 
                    VALUES (:dni, :nombre, :apellidos, :email, :password, :provincia, :sexo, :edad, :estado_civil, :aficiones, :estudios, :tipo)";
            
            $stmt = $pdo->prepare($sql);
            
            // Usar execute() con array en lugar de bindParam()
            $resultado = $stmt->execute([
                ':dni' => $u->dni,
                ':nombre' => $u->nombre,
                ':apellidos' => $u->apellidos,
                ':email' => $u->email,
                ':password' => $u->password,
                ':provincia' => $u->provincia,
                ':sexo' => $u->sexo,
                ':edad' => $u->edad,
                ':estado_civil' => $u->estado_civil,
                ':aficiones' => $u->aficiones,
                ':estudios' => $u->estudios,
                ':tipo' => $u->tipo
            ]);
            
            return $resultado ? $stmt->rowCount() : 0;
        } catch (PDOException $ex) {
            echo "<a href='../view/registro.php'>Ir a registro</a>";
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
    

    public static function actualizar($u){
        try{
            $conex = new ConexionPDO();
            $pdo = $conex->getConexion();
            
            $sql = "UPDATE usuarios SET 
                    dni = :dni,
                    nombre = :nombre,
                    apellidos = :apellidos,
                    email = :email,
                    provincia = :provincia,
                    sexo = :sexo,
                    edad = :edad,
                    estado_civil = :estado_civil,
                    aficiones = :aficiones,
                    estudios = :estudios,
                    tipo = :tipo
                    WHERE id = :id";
            
            $stmt = $pdo->prepare($sql);
            
            $resultado = $stmt->execute([
                ':dni' => $u->dni,
                ':nombre' => $u->nombre,
                ':apellidos' => $u->apellidos,
                ':email' => $u->email,
                ':provincia' => $u->provincia,
                ':sexo' => $u->sexo,
                ':edad' => $u->edad,
                ':estado_civil' => $u->estado_civil,
                ':aficiones' => $u->aficiones,
                ':estudios' => $u->estudios,
                ':tipo' => $u->tipo,
                ':id' => $u->id
            ]);
            
            return $resultado ? $stmt->rowCount() : 0;
        } catch (PDOException $ex) {
            echo "<a href='../view/admin.php'>Ir a admin</a>";
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }

    public static function buscarPorEmail($email){
        try{
            $conex = new ConexionPDO();
            $pdo = $conex->getConexion();
            
            $sql = "SELECT * FROM usuarios WHERE email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':email' => $email]);
            
            if($stmt->rowCount()){
                $reg = $stmt->fetch(PDO::FETCH_OBJ);
                $u = new Usuario(
                    $reg->id,
                    $reg->dni,
                    $reg->nombre,
                    $reg->apellidos,
                    $reg->email,
                    $reg->password,
                    $reg->provincia,
                    $reg->sexo,
                    $reg->edad,
                    $reg->estado_civil,
                    $reg->aficiones,
                    $reg->estudios,
                    $reg->fecha_registro,
                    $reg->tipo
                );
            } else {
                $u = false;
            }
            return $u;
        } catch (PDOException $ex) {
            echo "<a href='../view/login.php'>Ir a login</a>";
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
    
    public static function buscarPorDni($dni){
        try{
            $conex = new ConexionPDO();
            $pdo = $conex->getConexion();
            
            $sql = "SELECT * FROM usuarios WHERE dni = :dni";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':dni' => $dni]);
            
            if($stmt->rowCount()){
                $reg = $stmt->fetch(PDO::FETCH_OBJ);
                $u = new Usuario(
                    $reg->id,
                    $reg->dni,
                    $reg->nombre,
                    $reg->apellidos,
                    $reg->email,
                    $reg->password,
                    $reg->provincia,
                    $reg->sexo,
                    $reg->edad,
                    $reg->estado_civil,
                    $reg->aficiones,
                    $reg->estudios,
                    $reg->fecha_registro,
                    $reg->tipo
                );
            } else {
                $u = false;
            }
            return $u;
        } catch (PDOException $ex) {
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
    
    public static function buscarPorId($id){
        try{
            $conex = new ConexionPDO();
            $pdo = $conex->getConexion();
            
            $sql = "SELECT * FROM usuarios WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            
            if($stmt->rowCount()){
                $reg = $stmt->fetch(PDO::FETCH_OBJ);
                $u = new Usuario(
                    $reg->id,
                    $reg->dni,
                    $reg->nombre,
                    $reg->apellidos,
                    $reg->email,
                    $reg->password,
                    $reg->provincia,
                    $reg->sexo,
                    $reg->edad,
                    $reg->estado_civil,
                    $reg->aficiones,
                    $reg->estudios,
                    $reg->fecha_registro,
                    $reg->tipo
                );
            } else {
                $u = false;
            }
            return $u;
        } catch (PDOException $ex) {
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
    
    public static function obtenerTodos(){
        try{
            $conex = new ConexionPDO();
            $pdo = $conex->getConexion();
            
            $sql = "SELECT * FROM usuarios ORDER BY fecha_registro DESC";
            $stmt = $pdo->query($sql);
            
            $usuarios = array();
            if($stmt->rowCount()){
                while($reg = $stmt->fetch(PDO::FETCH_OBJ)){
                    $u = new Usuario(
                        $reg->id,
                        $reg->dni,
                        $reg->nombre,
                        $reg->apellidos,
                        $reg->email,
                        $reg->password,
                        $reg->provincia,
                        $reg->sexo,
                        $reg->edad,
                        $reg->estado_civil,
                        $reg->aficiones,
                        $reg->estudios,
                        $reg->fecha_registro,
                        $reg->tipo
                    );
                    $usuarios[] = $u;
                }
            }
            return $usuarios;
        } catch (PDOException $ex) {
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
    
    public static function eliminar($id){
        try{
            $conex = new ConexionPDO();
            $pdo = $conex->getConexion();
            
            $sql = "DELETE FROM usuarios WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            
            return $stmt->rowCount();
        } catch (PDOException $ex) {
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
}
?>