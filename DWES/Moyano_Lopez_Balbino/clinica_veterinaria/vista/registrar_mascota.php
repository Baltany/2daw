<?php
session_start();

// CORRECCIÓN: Verificar sesión en lugar de cookie
if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
    exit();
}

require_once '../model/Usuario.php';
require_once '../model/Mascota.php';
require_once '../controller/MascotaController.php';

// CORRECCIÓN: Obtener usuario de sesión
$usuario = unserialize($_SESSION['usuario']);
//Protegiendo la ruta
if(!$usuario->esDuenio()) {
    header("Location: menu.php");
    exit();
}


$mascota = null;
$es_edicion = false;
$errores = array();
$mensaje = "";

// 5. VERIFICAR SI ES EDICIÓN (viene con ?id=)
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $mascota = MascotaController::buscarPorId($id);
    
    // Verificar que la mascota pertenece al usuario logueado
    if(!$mascota || $mascota->id_usuario != $usuario->id){
        header("Location: mis_mascotas.php");
        exit();
    }
    
    $es_edicion = true;
}

// 6. VALIDACIONES
function validarEdad($edad){
    return is_numeric($edad) && $edad > 0;
}

function validarFoto($foto){
    if($foto['error'] != 0){
        return false;
    }
    $extension = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));
    return $extension == 'jpg';
}

// 7. PROCESAR FORMULARIO
if(isset($_POST['registrar'])){
    // Recoger datos del formulario
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $especie = isset($_POST['especie']) ? $_POST['especie'] : '';
    $raza = isset($_POST['raza']) ? trim($_POST['raza']) : '';
    $edad = isset($_POST['edad']) ? $_POST['edad'] : '';
    $foto_archivo = $_FILES['foto'] ?? null;
    
    // VALIDACIONES - Campos obligatorios
    if(empty($nombre)){
        $errores[] = "El nombre de la mascota es obligatorio";
    }
    
    if(empty($especie)){
        $errores[] = "Debes seleccionar una especie";
    }
    
    if(empty($raza)){
        $errores[] = "La raza es obligatoria";
    }
    
    if(empty($edad)){
        $errores[] = "La edad es obligatoria";
    } elseif(!validarEdad($edad)){
        $errores[] = "La edad debe ser un número válido mayor a 0";
    }
    
    // Validar foto
    $nombre_foto = null;
    
    if($es_edicion){
        // En edición, foto es OPCIONAL
        if($foto_archivo && $foto_archivo['error'] == 0){
            if(!validarFoto($foto_archivo)){
                $errores[] = "La foto debe ser un archivo .jpg válido";
            } else {
                // Generar nombre único y mover archivo
                $nombre_foto = time() . "_" . $nombre . ".jpg";
                $ruta = "../imagenes/" . $nombre_foto;
                
                // Borrar foto anterior si existe
                if(!empty($mascota->foto) && file_exists($ruta)){
                    unlink($ruta);
                }
                
                if(!move_uploaded_file($foto_archivo['tmp_name'], $ruta)){
                    $errores[] = "Error al subir la foto";
                }
            }
        } else {
            // Mantener foto anterior si no se sube nueva
            $nombre_foto = $mascota->foto;
        }
    } else {
        // En nuevo, foto es OBLIGATORIA
        if(!$foto_archivo || $foto_archivo['error'] != 0){
            $errores[] = "La foto es obligatoria para registrar una mascota";
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
    
    // Si no hay errores, procesar
    if(empty($errores)){
        if($es_edicion){
            // EDITAR mascota existente
            $mascota_actualizada = new Mascota(
                $mascota->id,
                $nombre,
                $especie,
                $raza,
                $edad,
                $nombre_foto,
                $usuario->id,
                $mascota->fecha_registro
            );
            
            $resultado = MascotaController::actualizar($mascota_actualizada);
            
            if($resultado){
                $_SESSION['mensaje'] = "Mascota actualizada correctamente";
                header("Location: mis_mascotas.php");
                exit();
            } else {
                $errores[] = "Error al actualizar la mascota";
            }
        } else {
            // INSERTAR nueva mascota
            $nueva_mascota = new Mascota(
                0,  // ID se genera automáticamente
                $nombre,
                $especie,
                $raza,
                $edad,
                $nombre_foto,
                $usuario->id,
                date('Y-m-d H:i:s')
            );
            
            $resultado = MascotaController::insertar($nueva_mascota);
            
            if($resultado){
                $_SESSION['mensaje'] = "Mascota registrada correctamente";
                header("Location: mis_mascotas.php");
                exit();
            } else {
                $errores[] = "Error al registrar la mascota";
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis mascotas</title>
</head>

<body>
    <h1>Panel de <?php echo $usuario->rol; ?></h1>

    <p>Bienvenido/a: <?php echo $usuario->nombre; ?>
        <a href="logout.php">Cerrar Sesión</a>
    </p>

    <hr>

    <h2>Registrar mascota</h2>
    <h2><?php echo $es_edicion ? "Editar Mascota" : "Registrar Nueva Mascota"; ?></h2>

    <!-- MOSTRAR ERRORES -->
    <?php if(!empty($errores)): ?>
    <div class="errores">
        <h3>Errores encontrados:</h3>
        <ul>
            <?php foreach($errores as $error): ?>
            <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <!-- FORMULARIO CON TABLA -->
    <form method="POST" enctype="multipart/form-data">
        <table>
            <tr>
                <th colspan="2">Datos de la Mascota</th>
            </tr>

            <tr>
                <td><label>Nombre de la mascota:</label></td>
                <td><input type="text" name="nombre" value="<?php echo $mascota ? $mascota->nombre : ''; ?>" required>
                </td>
            </tr>

            <tr>
                <td><label>Especie:</label></td>
                <td>
                    <select name="especie" required>
                        <option value="">-- Selecciona especie --</option>
                        <option value="perro"
                            <?php echo ($mascota && $mascota->especie == 'perro') ? 'selected' : ''; ?>>Perro</option>
                        <option value="gato" <?php echo ($mascota && $mascota->especie == 'gato') ? 'selected' : ''; ?>>
                            Gato</option>
                        <option value="conejo"
                            <?php echo ($mascota && $mascota->especie == 'conejo') ? 'selected' : ''; ?>>Conejo</option>
                        <option value="pájaro"
                            <?php echo ($mascota && $mascota->especie == 'pájaro') ? 'selected' : ''; ?>>Pájaro</option>
                        <option value="roedor"
                            <?php echo ($mascota && $mascota->especie == 'roedor') ? 'selected' : ''; ?>>Roedor</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td><label>Raza:</label></td>
                <td><input type="text" name="raza" value="<?php echo $mascota ? $mascota->raza : ''; ?>" required></td>
            </tr>

            <tr>
                <td><label>Edad (años):</label></td>
                <td><input type="number" name="edad" value="<?php echo $mascota ? $mascota->edad : ''; ?>" required>
                </td>
            </tr>

            <tr>
                <td><label>Foto (.jpg):</label></td>
                <td>
                    <?php if($es_edicion && $mascota->foto): ?>
                    <p><small><strong>Foto actual:</strong></small></p>
                    <img src="../../imagenes/<?php echo $mascota->foto; ?>" alt="<?php echo $mascota->nombre; ?>">
                    <p><small><em>(Sube una nueva foto para cambiarla)</em></small></p>
                    <?php endif; ?>
                    <input type="file" name="foto" accept=".jpg" <?php echo !$es_edicion ? 'required' : ''; ?>>
                </td>
            </tr>

            <tr>
                <td colspan="2" style="text-align: center; padding-top: 20px;">
                    <input type="submit" name="registrar"
                        value="<?php echo $es_edicion ? 'Actualizar Mascota' : 'Registrar Mascota'; ?>">
                </td>
            </tr>
        </table>
    </form>

    <br>
    <a href="menu.php">Volver al menú</a>

</body>

</html>