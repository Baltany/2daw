<?php
session_start();

if(!isset($_SESSION['profesor'])){
    header("Location: login.php");
    exit();
}

require_once '../model/Profesor.php';
require_once '../model/Curso.php';
require_once '../model/Alumno.php';
require_once '../model/Parte.php';

require_once '../controller/CursoController.php';
require_once '../controller/AlumnoController.php';
require_once '../controller/ParteController.php';

$es_insertar = false;
$parte = null;
$errores = array();


$profesor = unserialize($_SESSION['profesor']);

    $nombre_foto = null;
    
    if($es_edicion){
        // En edición, foto es OPCIONAL
        if($foto_archivo && $foto_archivo['error'] == 0){
            if(!validarFoto($foto_archivo)){
                $errores[] = "La foto debe ser un archivo .jpg válido";
            } else {
                // Generar nombre único y mover archivo
                $nombre_foto = time() . "_" . $nombre . ".jpg";
                $ruta = "../imagenpartes/" . $nombre_foto;
                
                // Borrar foto anterior si existe
                if(!empty($parte->foto) && file_exists($ruta)){
                    unlink($ruta);
                }
                
                if(!move_uploaded_file($foto_archivo['tmp_name'], $ruta)){
                    $errores[] = "Error al subir la foto";
                }
            }
        } else {
            // Mantener foto anterior si no se sube nueva
            $nombre_foto = $parte->foto;
        }
    } else {
        // En nuevo, foto es OBLIGATORIA
        if(!$foto_archivo || $foto_archivo['error'] != 0){
            $errores[] = "La foto es obligatoria para registrar una parte";
        } elseif(!validarFoto($foto_archivo)){
            $errores[] = "La foto debe ser un archivo .jpg válido";
        } else {
            // Generar nombre único y mover archivo
            $nombre_foto = time() . "_" . $nombre . ".jpg";
            $ruta = "../imagenes/" . $nombre_foto;
            if(!move_uploaded_file($foto_archivo['tmp_name'], $ruta)){
                $errores[] = "Error al subir la foto";
            }
        }
    }

    if(empty($errores)){
        if($es_insertar){
            $parte_creado = new Parte(
                $parte->dni_p,
                $dni_a,
                $time,
                $foto,
                $motivo,
                $id,
            );
            
            $resultado = ParteController::insertar($parte_creadoparte);
            
            if($resultado){
                $_SESSION['mensaje'] = "Parte añadido correctamente";
                header("Location: partes.php");
                exit();
            } else {
                $errores[] = "Error al actualizar la parte";
            }
        }
    
    }


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu-Balbino</title>
</head>

<body>
    <h1>Panel de <?php echo $profesor->dni_p; ?></h1>

    <p>Bienvenido/a profesor: <?php echo $profesor->nombre ." ". $profesor->apellidos; ?>
        <a href="logout.php">Cerrar Sesión</a>
    </p>

    <hr>

    <h2>Parte de incidencias</h2>

    <form method="POST" enctype="multipart/form-data">
        <table>
            <tr>
                <th colspan="2">Datos del Alumno</th>
            </tr>

            <tr>
                <td><label>Nombre del alumno:</label></td>
                <td><input type="text" name="nombre" value="<?php echo $parte ? $parte->nombre : ''; ?>" required>
                </td>
            </tr>


            <tr>
                <td><label>Motivo:</label></td>
                <td><input type="textarea" name="raza" value="<?php echo $parte ? $parte->motivo : ''; ?>" required>
                </td>
            </tr>


            <tr>
                <td><label>Foto (.jpg):</label></td>
                <td>
                    <?php if($es_edicion && $parte->foto): ?>
                    <p><small><strong>Foto actual:</strong></small></p>
                    <img src="../../imagenpartes/<?php echo $parte->foto; ?>" alt="<?php echo $parte->nombre; ?>">
                    <p><small><em>(Sube una nueva foto para cambiarla)</em></small></p>
                    <?php endif; ?>
                    <input type="file" name="foto" accept=".jpg" <?php echo !$es_edicion ? 'required' : ''; ?>>
                </td>
            </tr>

            <tr>
                <td colspan="2" style="text-align: center; padding-top: 20px;">
                    <input type="submit" name="registrar" value="<?php echo $es_edicion . 'Grabar Parte'; ?>">
                </td>
            </tr>
        </table>
    </form>


    <br>

    <a href="partes.php">Volver</a>




</body>

</html>