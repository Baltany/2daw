<?php
require_once '../model/Conexion.php';
require_once '../model/Curso.php';

class CursoController{
    public static function buscarPorId($id_curso){
        try{
            $conex = new Conexion();
            $pdo = $conex->getConexion();

            $sql = "SELECT * FROM curso WHERE id_curso = :id_curso";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id_curso' => $id_curso]);

            if($stmt->rowCount()){
                $reg = $stmt->fetch(PDO::FETCH_OBJ);
                $p = new Curso(
                    $reg->id_curso,
                    $reg->descripcion,
                    $reg->totalpartes
                );
            }else{
                $p = false;
            }
            return $p;
        }catch(PDOException $ex){
            die("Error con la bd: " . $ex->getMessage());
        }
    }
}



?>