<?php
require_once '../controlador/TareasController.php';
require_once '../model/Empleado.php';

session_name("emp");
session_start();

if (!isset($_SESSION['emp'])) {
    header("Location: login.php");
    exit();
}

$empleado = $_SESSION['emp'];

$mensaje = "";

if (isset($_POST['crear'])) {
    if (!empty($_POST['feini']) && !empty($_POST['fefin']) && !empty($_POST['horas'])) {
        if (TareasController::crearTarea($empleado->id, $_POST['feini'], $_POST['fefin'], $_POST['horas'])) {
            $mensaje = "<div class='exito'>Tarea creada correctamente</div>";
        } else {
            $mensaje = "<div class='error'>Error al crear la tarea</div>";
        }
    } else {
        $mensaje = "<div class='error'>Por favor, completa todos los campos</div>";
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Nueva Tarea</title>
</head>
<body>
    <h1>Nueva Tarea</h1>
    <p>Empleado: <strong><?= $empleado->nombre ?></strong></p>
    
    <?= $mensaje ?>
    
    <form action="" method="post">
        <label>Fecha Inicio:</label>
        <input type="date" name="feini" required>
        
        <label>Fecha Fin:</label>
        <input type="date" name="fefin" required>
        
        <label>Horas:</label>
        <input type="number" name="horas" min="0" step="1" value="0" required>
        
        <input type="submit" name="crear" value="Crear Tarea">
    </form>
    
    <button><a href="inicio.php">Volver</a></button>
</body>
</html>