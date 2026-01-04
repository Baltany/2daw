<?php
session_start();

if(!isset($_SESSION['empleado'])){
    header("Location: login.php");
    exit();
}

require_once '../controller/TrabajoController.php';
require_once '../controller/EmpleadoController.php';
require_once '../controller/CocheController.php';
require_once '../controller/TareaController.php';
require_once '../model/Trabajo.php';

$empleado = unserialize($_SESSION['empleado']);
$empleado = EmpleadoController::buscarPorCodigo($empleado->codigo);

$trabajos = null;
$coche = null;
$mensaje = "";
$tareas_trabajo = array();

// MECÁNICO: Obtener TODOS los trabajos asignados (sin filtro de fecha)
if($empleado->esMecanico()){
    $trabajos = TrabajoController::obtenerTodosPorMecanico($empleado->codigo);
}

// ADMIN: Buscar trabajos por matrícula y fecha
if($empleado->esAdmin()){
    if(isset($_POST['buscar'])){
        $matricula = strtoupper(trim($_POST['matricula']));
        $fecha = $_POST['fecha'];
        
        if(empty($matricula) || empty($fecha)){
            $mensaje = "<p style='color: red;'>Debe ingresar matrícula y fecha</p>";
        } else {
            $trabajos = TrabajoController::obtenerPorMatriculaYFecha($matricula, $fecha);
            
            if($trabajos){
                $coche = CocheController::buscarPorMatricula($matricula);
            } else {
                $mensaje = "<p style='color: orange;'>No se encontraron tareas para esa matrícula en esa fecha</p>";
            }
        }
    }
    
    // Facturar trabajos
    if(isset($_POST['facturar'])){
        $matricula = strtoupper(trim($_POST['matricula_factura']));
        $fecha = $_POST['fecha_factura'];
        
        $resultado = TrabajoController::facturar($matricula, $fecha);
        
        if($resultado){
            $mensaje = "<p style='color: green;'>Factura creada correctamente</p>";
            $trabajos = TrabajoController::obtenerPorMatriculaYFecha($matricula, $fecha);
            $coche = CocheController::buscarPorMatricula($matricula);
        } else {
            $mensaje = "<p style='color: red;'>Error al crear la factura</p>";
        }
    }
}

// MECÁNICO: Actualizar estado y horas de tarea
if(isset($_POST['actualizar_tarea'])){
    $matricula = $_POST['matricula_tarea'];
    $cod_mecanico = $_POST['cod_mecanico_tarea'];
    $id_tarea = $_POST['id_tarea'];
    $fecha = $_POST['fecha_tarea'];
    $estado = $_POST['estado'];
    $horas = $_POST['horas'];
    
    if(empty($estado) || empty($horas) || !is_numeric($horas)){
        $mensaje = "<p style='color: red;'>Estado y horas son obligatorios. Las horas deben ser numéricas</p>";
    } else {
        $resultado = TrabajoController::actualizar($matricula, $cod_mecanico, $id_tarea, $fecha, $estado, $horas);
        
        if($resultado){
            $mensaje = "<p style='color: green;'>Tarea actualizada correctamente</p>";
            // Recargar trabajos
            $trabajos = TrabajoController::obtenerTodosPorMecanico($cod_mecanico);
        } else {
            $mensaje = "<p style='color: red;'>Error al actualizar la tarea</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trabajos</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        img { max-width: 150px; }
    </style>
</head>
<body>
    <h1>Panel de <?php echo $empleado->rol; ?></h1>
    
    <p>Bienvenido/a: <?php echo $empleado->nombre; ?> 
    <a href="logout.php">Cerrar Sesión</a> | <a href="menu.php">Volver al menú</a></p>
    
    <hr>
    
    <?php echo $mensaje; ?>
    
    <?php if($empleado->esMecanico()): ?>
        <h2>Mis Trabajos Asignados</h2>
        
        <?php if($trabajos): ?>
            <table>
                <tr>
                    <th>Matrícula</th>
                    <th>Tarea</th>
                    <th>Estado Actual</th>
                    <th>Horas</th>
                    <th>Acción</th>
                </tr>
                <?php foreach($trabajos as $trabajo): ?>
                    <tr>
                        <td><?php echo $trabajo->matricula; ?></td>
                        <td><?php 
                            $tarea = TareaController::buscarPorId($trabajo->id_tarea);
                            echo $tarea ? $tarea->descripcion : "Tarea #" . $trabajo->id_tarea;
                        ?></td>
                        <td><?php echo $trabajo->estado; ?></td>
                        <td><?php echo $trabajo->horas; ?></td>
                        <td>
                            <form action="" method="POST" style="display:inline;">
                                <input type="hidden" name="matricula_tarea" value="<?php echo $trabajo->matricula; ?>">
                                <input type="hidden" name="cod_mecanico_tarea" value="<?php echo $trabajo->cod_mecanico; ?>">
                                <input type="hidden" name="id_tarea" value="<?php echo $trabajo->id_tarea; ?>">
                                <input type="hidden" name="fecha_tarea" value="<?php echo $trabajo->fecha; ?>">
                                
                                <select name="estado" required>
                                    <option value="Pendiente" <?php echo $trabajo->estado === 'Pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                                    <option value="En proceso" <?php echo $trabajo->estado === 'En proceso' ? 'selected' : ''; ?>>En proceso</option>
                                    <option value="Completada" <?php echo $trabajo->estado === 'Completada' ? 'selected' : ''; ?>>Completada</option>
                                </select>
                                
                                <input type="number" name="horas" value="<?php echo $trabajo->horas; ?>" min="0" required>
                                
                                <input type="submit" name="actualizar_tarea" value="Actualizar">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No tienes trabajos registrados para hoy.</p>
        <?php endif; ?>
    
    <?php elseif($empleado->esAdmin()): ?>
        <h2>Búsqueda de Trabajos</h2>
        
        <form action="" method="POST">
            <label>Matrícula del coche:</label>
            <input type="text" name="matricula" placeholder="Ej: 1111AAA" required>
            
            <label>Fecha:</label>
            <input type="date" name="fecha" required>
            
            <input type="submit" name="buscar" value="Buscar">
        </form>
        
        <hr>
        
        <?php if($trabajos && $coche): ?>
            <div style="margin-top: 20px;">
                <?php if($coche->foto): ?>
                    <img src="../imagenes/<?php echo $coche->foto; ?>" alt="Foto del coche">
                <?php endif; ?>
                
                <h3>Las tareas realizadas sobre el coche <?php echo $coche->marca; ?> <?php echo $coche->modelo; ?> con matrícula <?php echo $coche->matricula; ?> SON:</h3>
                
                <table>
                    <tr>
                        <th>Tarea</th>
                        <th>Estado</th>
                        <th>Horas</th>
                        <th>PVP/Hora</th>
                        <th>Total</th>
                    </tr>
                    <?php 
                    $total_factura = 0;
                    $todos_completados = true;
                    
                    foreach($trabajos as $trabajo): 
                        $tarea = TareaController::buscarPorId($trabajo->id_tarea);
                        $subtotal = 0;
                        
                        if($tarea){
                            if($trabajo->estado === 'Completada'){
                                $pvp_hora = $tarea->precio / 2; // Asumiendo 2 horas como base
                                $subtotal = $pvp_hora * $trabajo->horas;
                                $total_factura += $subtotal;
                            } else {
                                $todos_completados = false;
                            }
                    ?>
                        <tr>
                            <td><?php echo $tarea->descripcion; ?></td>
                            <td><?php echo $trabajo->estado; ?></td>
                            <td><?php echo $trabajo->horas; ?></td>
                            <td><?php echo $tarea->precio; ?>€</td>
                            <td><?php echo $trabajo->estado === 'Completada' ? number_format($subtotal, 2) . '€' : '0€'; ?></td>
                        </tr>
                    <?php 
                        }
                    endforeach; 
                    ?>
                </table>
                
                <?php if($todos_completados): ?>
                    <form action="" method="POST" style="margin-top: 20px;">
                        <input type="hidden" name="matricula_factura" value="<?php echo $coche->matricula; ?>">
                        <input type="hidden" name="fecha_factura" value="<?php echo $trabajos[0]->fecha; ?>">
                        <input type="submit" name="facturar" value="Crear Factura">
                    </form>
                <?php else: ?>
                    <p style="color: red; margin-top: 20px;"><strong>No se puede crear la factura porque hay tareas sin completar</strong></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    
</body>
</html>