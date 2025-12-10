<?php
require_once '../model/Empleado.php';

session_name("emp");
session_start();

if (!isset($_SESSION['emp'])) {
    header("Location: login.php");
    exit();
}

$empleado = $_SESSION['emp'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Inicio - Gestión de Tareas</title>
</head>
<body>
    <h1>Bienvenido, <?= $empleado->nombre ?></h1>
    <p><strong>Departamento:</strong> <?= $empleado->departamento ?></p>
    
    <div class="menu">
        <h2>Menú de Tareas</h2>
        <a href="nueva.php"> Nueva Tarea</a>
        <a href="modificar.php"> Actualizar Tarea</a>
    </div>
    <br>
    <a href="cerrar.php">Salir</a>
</body>
</html>