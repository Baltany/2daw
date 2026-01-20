<?php
require_once '../model/Conexion.php';
require_once '../model/Alumno.php';

class AlumnoController{
    public static function buscarPorCurso($id_curso){
        try{
            $conex = new Conexion();
            $pdo = $conex->getConexion();

            $sql = "SELECT * FROM alumnos WHERE id_curso = :id_curso";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id_curso' => $id_curso]);

            if($stmt->rowCount()){
                $reg = $stmt->fetch(PDO::FETCH_OBJ);
                $p = new Alumno(
                    $reg->dni_a,
                    $reg->nombre,
                    $reg->direccion,
                    $reg->telf,
                    $reg->apellidos,
                    $reg->id_curso
                    
                );
            }else{
                $p = false;
            }
            return $p;
        }catch(PDOException $ex){
            die("Error con la bd: " . $ex->getMessage());
        }
    }

    public static function buscarPorDni($dni_a){
        try{
            $conex = new Conexion();
            $pdo = $conex->getConexion();

            $sql = "SELECT * FROM alumnos WHERE dni_a = :dni_a";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':dni_a' => $dni_a]);

            if($stmt->rowCount()){
                $reg = $stmt->fetch(PDO::FETCH_OBJ);
                $p = new Alumno(
                    $reg->dni_a,
                    $reg->nombre,
                    $reg->direccion,
                    $reg->telf,
                    $reg->apellidos,
                    $reg->id_curso
                    
                );
            }else{
                $p = false;
            }
            return $p;
        }catch(PDOException $ex){
            die("Error con la bd: " . $ex->getMessage());
        }
    }

    public static function mostrarAlumnos($id_curso){
        try{
            $conex = new Conexion();
            $pdo = $conex->getConexion();
            
            $sql = "SELECT * FROM alumnos WHERE id_curso = :id_curso";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id_curso' => $id_curso]);

            
            $alumnos = array();
            if($stmt->rowCount()){
                while($reg = $stmt->fetch(PDO::FETCH_OBJ)){
                    $a = new Alumno(
                    $reg->dni_a,
                    $reg->nombre,
                    $reg->direccion,
                    $reg->telf,
                    $reg->apellidos,
                    $reg->id_curso
                    
                    );
                    $alumnos[] = $a;
                }
            }else{
                $alumnos = false;
            }
            return $alumnos;
        }catch(PDOException $ex){
            die("ERROR CON LA BD: " . $ex->getMessage());
        }
    }
}



?>