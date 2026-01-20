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

$profesor = unserialize($_SESSION['profesor']);
$parte = null;
$alumno = null;
$errores = array();
$mensaje = "";

if(isset($_GET['eliminar'])){
    $id_parte = $_GET['eliminar'];
    $resultado = ParteController::eliminarParte($id_parte);
    if($resultado){
        $mensaje = "Parte eliminado correctamente";
        header("Location: " . $_SERVER['PHP_SELF'] . "?id=" . $_GET['id']);
        exit();
    }else{
        $errores[] = "Error al eliminar el parte";
    }
}

if(isset($_GET['id'])){
    $dni_a = $_GET['id'];
    $alumno = AlumnoController::buscarPorDni($dni_a);
    $parte = ParteController::mostrarAlumnos($dni_a);
    
    if(!$alumno){
        $errores[] = "Alumno no encontrado";
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Partes</title>
</head>

<body>
    <h1>Panel de <?php echo $profesor->dni_p; ?></h1>

    <p>Bienvenido/a profesor: <?php echo $profesor->nombre . " " . $profesor->apellidos; ?>
        <a href="logout.php">Cerrar Sesión</a>
    </p>

    <hr>

    <?php if(!empty($mensaje)): ?>
    <p><?php echo $mensaje; ?></p>
    <?php endif; ?>

    <?php if(!empty($errores)): ?>
    <div>
        <h3>Errores encontrados:</h3>
        <ul>
            <?php foreach($errores as $error): ?>
            <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <?php if($alumno): ?>
    <h2>Historial de partes del alumno <?php echo $alumno->nombre . " " . $alumno->apellidos; ?></h2>

    <?php if($parte): ?>
    <table border="1">
        <tr>
            <td>Fecha</td>
            <td>Profesor</td>
            <td>Motivo</td>
            <td>Acciones</td>
        </tr>
        <?php foreach($parte as $p): ?>
        <tr>
            <td><?php echo date("d/m/Y H:i", $p->time); ?></td>
            <td><?php echo $profesor->nombre; ?></td>
            <td><?php echo $p->motivo; ?></td>
            <td>
                <a href="?id=<?php echo $dni_a; ?>&eliminar=<?php echo $p->id; ?>"
                    onclick="return confirm('¿Deseas eliminar este parte?');">Quitar Parte</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php else: ?>
    <p>Este alumno no tiene partes registrados</p>
    <?php endif; ?>

    <?php endif; ?>

    <br>
    <a href="partes.php">Volver</a>

</body>

</html>