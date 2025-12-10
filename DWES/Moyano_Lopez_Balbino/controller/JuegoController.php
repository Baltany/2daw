<?php
require_once 'model/Juego.php';

class JuegoController{
    
    public static function listarTodos(){
        return Juego::mostrar();
    }
    
    public static function listarAlquilados(){
        return Juego::mostrarAlquilados();
    }
    
    public static function listarNoAlquilados(){
        return Juego::mostrarNoAlquilados();
    }
    
    public static function buscar($codigo){
        return Juego::buscar($codigo);
    }
    
    public static function crear(){
        if(isset($_POST['crear'])){
            // Manejo de subida de imagen
            $imagen = "";
            if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0){
                $carpeta = "imagenes/";
                $nombre_archivo = time() . $_FILES['imagen']['name'];
                $ruta_completa = $carpeta . $nombre_archivo;
                move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_completa);
                $imagen = $ruta_completa;
            }
            
            $juego = new Juego(
                $_POST['codigo'],
                $_POST['nombre'],
                $_POST['consola'],
                $_POST['anno'],
                $_POST['precio'],
                'NO',
                $imagen,
                $_POST['descripcion']
            );
            
            if($juego->insertar()){
                return "Juego creado correctamente";
            }else{
                return "Error al crear el juego";
            }
        }
    }
    
    public static function modificar(){
        if(isset($_POST['modificar'])){
            $juego_actual = Juego::buscar($_POST['codigo']);
            $imagen = $juego_actual->Imagen;
            
            // Si se sube nueva imagen
            if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0){
                $carpeta = "imagenes/";
                $nombre_archivo = time() . $_FILES['imagen']['name'];
                $ruta_completa = $carpeta . $nombre_archivo;
                move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_completa);
                $imagen = $ruta_completa;
            }
            
            $juego = new Juego(
                $_POST['codigo'],
                $_POST['nombre'],
                $_POST['consola'],
                $_POST['anno'],
                $_POST['precio'],
                $juego_actual->Alguilado,
                $imagen,
                $_POST['descripcion']
            );
            
            if($juego->actualizar()){
                return "Juego modificado correctamente";
            }else{
                return "Error al modificar el juego";
            }
        }
    }
    
    public static function eliminar(){
        if(isset($_POST['eliminar'])){
            $codigo = $_POST['codigo'];
            if(Juego::eliminar($codigo)){
                return "Juego eliminado correctamente";
            }else{
                return "Error al eliminar el juego";
            }
        }
    }
}
?>