<?php
require_once '../controlador/TareasController.php';
require_once '../model/Empleado.php';
require_once '../model/Tarea.php';

session_name("emp");
session_start();

if (!isset($_SESSION['emp'])) {
    header("Location: login.php");
    exit();
}

$empleado = $_SESSION['emp'];

$mensaje = "";

if (isset($_POST['modificar'])) {
    if (TareasController::modificarTarea($_POST['id'], $_POST['horas'])) {
        $mensaje = "<div class='exito'>Modificación realizada correctamente</div>";
    } else {
        $mensaje = "<div class='error'>Ocurrió un error al intentar modificar la tarea</div>";
    }
}

if (isset($_POST['eliminar'])) {
    if (TareasController::eliminarTarea($_POST['id'])) {
        $mensaje = "<div class='exito'>Tarea eliminada correctamente</div>";
    } else {
        $mensaje = "<div class='error'>Ocurrió un error al intentar eliminar la tarea</div>";
    }
}

$tareas = TareasController::getTareas($empleado->id);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Modificar Tareas</title>
</head>
<body>
    <h1>Actualizar Tareas</h1>
    <p>Empleado: <strong><?= $empleado->nombre ?></strong></p>
    
    <?= $mensaje ?>
    
    <?php if (empty($tareas)): ?>
        <div>
            <p>No tienes tareas asignadas actualmente.</p>
        </div>
    <?php else: ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Horas</th>
                <th>Acciones</th>
            </tr>
            <?php
            foreach ($tareas as $t) {
                echo "<tr>";
                echo "<td>$t->id</td>";
                echo "<td>$t->fecha_ini</td>";
                echo "<td>$t->fecha_fin</td>";
                echo "<td>";
                echo "<form action='' method='post' style='display:inline;'>";
                echo "<input type='number' name='horas' value='$t->horas' min='0' step='1' required>";
                echo "<input type='hidden' name='id' value='$t->id'>";
                echo "</td>";
                echo "<td class='acciones'>";
                echo "<input type='submit' name='modificar' value='Modificar'>";
                echo "</form>";
                echo "<form action='' method='post' style='display:inline;' onsubmit='return confirm(\"¿Estás seguro de eliminar esta tarea?\")'>";
                echo "<input type='hidden' name='id' value='$t->id'>";
                echo "<input type='submit' name='eliminar' value='Eliminar'>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </table>
    <?php endif; ?>
    
    <button><a href="inicio.php">Volver</a></button>
</body>
</html>
