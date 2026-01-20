<?php
session_start();

if(!isset($_SESSION['empleado'])){
    header("Location: login.php");
    exit();
}

require_once '../model/Empleado.php';
require_once '../model/Cliente.php';
require_once '../model/Coche.php';
require_once '../model/Conexion.php';
require_once '../controller/EmpleadoController.php';
require_once '../controller/ClienteController.php';
require_once '../controller/CocheController.php';
require_once '../controller/TareaController.php';
require_once '../controller/TrabajoController.php';

$empleado = unserialize($_SESSION['empleado']);

// Verificar que sea admin
if(!$empleado->esAdmin()){
    header("Location: menu.php");
    exit();
}

$errores = array();
$cliente = null;
$coches = null;
$coche_seleccionado = null;
$nuevo_coche = false;
$tareas = TareaController::mostrarPorTipo();
$mecanicos = EmpleadoController::mostrarMecanicos();

// Funciones de validación
function validarDNI($dni){
    return preg_match('/^[0-9]{8}[A-Z]$/', $dni);
}

function validarMatricula($matricula){
    // sin vocales
    return preg_match('/^[0-9]{4}[BCDFGHJKLMNPRSTVWXYZ]{3}$/', $matricula);
}

function validarTelefono($telf){
    return preg_match('/^[0-9]{9}$/', $telf);
}

// PASO 1: Buscar cliente por DNI
if(isset($_POST['buscar_cliente'])){
    $dni = strtoupper(trim($_POST['dni']));
    
    if(empty($dni)){
        $errores[] = "El DNI es obligatorio";
    }elseif(!validarDNI($dni)){
        $errores[] = "El DNI debe tener 8 dígitos y una letra mayúscula";
    }
    
    if(empty($errores)){
        $cliente = ClienteController::buscarPorDni($dni);
        
        if($cliente){
            $coches = CocheController::mostrarPorDni($dni);
        }else{
            $errores[] = "El DNI introducido no existe en la base de datos";
        }
    }
}

// PASO 2: Seleccionar coche existente
if(isset($_POST['seleccionar_coche'])){
    $dni = $_POST['dni_cliente'];
    $matricula = $_POST['matricula_sel'];
    
    $cliente = ClienteController::buscarPorDni($dni);
    $coche_seleccionado = CocheController::buscarPorMatricula($matricula);
    $coches = CocheController::mostrarPorDni($dni);
}

// PASO 3: Añadir nuevo coche
if(isset($_POST['nuevo_coche'])){
    $dni = $_POST['dni_cliente'];
    $cliente = ClienteController::buscarPorDni($dni);
    $coches = CocheController::mostrarPorDni($dni);
    $nuevo_coche = true;
}

// PASO 4: Volver atrás
if(isset($_POST['volver'])){
    $dni = $_POST['dni_cliente'];
    $cliente = ClienteController::buscarPorDni($dni);
    $coches = CocheController::mostrarPorDni($dni);
    $coche_seleccionado = null;
    $nuevo_coche = false;
}

// PASO 5: Registrar trabajo (validar y guardar)
if(isset($_POST['registrar'])){
    // Recoger datos
    $dni_cliente = trim($_POST['dni_cliente']);
    $nombre_cliente = trim($_POST['nombre_cliente']);
    $direccion_cliente = trim($_POST['direccion_cliente']);
    $telf_cliente = trim($_POST['telf_cliente']);
    
    $matricula = strtoupper(trim($_POST['matricula']));
    $marca = trim($_POST['marca']);
    $modelo = trim($_POST['modelo']);
    $km = trim($_POST['km']);
    $cod_mecanico = $_POST['cod_mecanico'];
    $tareas_seleccionadas = isset($_POST['tareas']) ? $_POST['tareas'] : array();
    
    $es_nuevo_coche = isset($_POST['es_nuevo_coche']) && $_POST['es_nuevo_coche'] == '1';
    $foto_actual = isset($_POST['foto_actual']) ? $_POST['foto_actual'] : '';
    
    // Validaciones
    if(!validarDNI($dni_cliente)){
        $errores[] = "El DNI debe tener 8 dígitos y una letra mayúscula";
    }
    
    if(empty($nombre_cliente)){
        $errores[] = "El nombre del cliente es obligatorio";
    }
    
    if(empty($direccion_cliente)){
        $errores[] = "La dirección es obligatoria";
    }
    
    if(!validarTelefono($telf_cliente)){
        $errores[] = "El teléfono debe tener 9 dígitos";
    }
    
    if(!validarMatricula($matricula)){
        $errores[] = "La matrícula debe tener 4 dígitos y 3 letras";
    }
    
    if(empty($marca)){
        $errores[] = "La marca es obligatoria";
    }
    
    if(empty($modelo)){
        $errores[] = "El modelo es obligatorio";
    }
    
    if(empty($km) || !is_numeric($km)){
        $errores[] = "Los kilómetros deben ser un número";
    }
    
    if(empty($tareas_seleccionadas)){
        $errores[] = "Debe seleccionar al menos una tarea";
    }
    
    if(empty($cod_mecanico)){
        $errores[] = "Debe seleccionar un mecánico";
    }
    
    // Validar y procesar imagen
    $ruta_foto = $foto_actual;
    if(isset($_FILES['foto']) && $_FILES['foto']['error'] == 0){
        $extension = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        
        if($extension != 'jpg'){
            $errores[] = "Solo se permiten archivos .jpg";
        }else{
            // Borrar foto antigua si existe
            if(!empty($foto_actual) && file_exists("../imagenes/" . $foto_actual)){
                unlink("../imagenes/" . $foto_actual);
            }
            
            // Subir nueva foto
            $nombre_foto = time() . "_" . $matricula . ".jpg";
            $ruta_completa = "../imagenes/" . $nombre_foto;
            
            if(move_uploaded_file($_FILES['foto']['tmp_name'], $ruta_completa)){
                $ruta_foto = $nombre_foto;
            }else{
                $errores[] = "Error al subir la imagen";
            }
        }
    }elseif($es_nuevo_coche){
        $errores[] = "La foto es obligatoria para un coche nuevo";
    }
    
    // Si no hay errores, procesar
    if(empty($errores)){
        try{
            $conex = new Conexion();
            $pdo = $conex->getConexion();
            
            // Iniciar transacción
            $pdo->beginTransaction();
            
            // 1. Actualizar datos del cliente
            $cliente_obj = new Cliente($dni_cliente, $nombre_cliente, $direccion_cliente, $telf_cliente);
            ClienteController::actualizar($cliente_obj);
            
            // 2. Insertar o actualizar coche
            $coche_obj = new Coche($matricula, $marca, $modelo, $km, $ruta_foto, $dni_cliente);
            
            if($es_nuevo_coche){
                CocheController::insertar($coche_obj);
            }else{
                CocheController::actualizar($coche_obj);
            }
            
            // 3. Registrar tareas
            $fecha_actual = date('Y-m-d');
            TrabajoController::insertarMultiples($matricula, $cod_mecanico, $tareas_seleccionadas, $fecha_actual);
            
            // Confirmar transacción
            $pdo->commit();
            
            $_SESSION['mensaje'] = "Se han registrado correctamente las tareas para el vehículo $marca $modelo con matrícula $matricula";
            header("Location: menu.php");
            exit();
            
        }catch(Exception $ex){
            $pdo->rollBack();
            $errores[] = "Error al registrar: " . $ex->getMessage();
        }
    }
    
    // Mantener datos en formulario
    $cliente = ClienteController::buscarPorDni($dni_cliente);
    if(!$es_nuevo_coche){
        $coche_seleccionado = CocheController::buscarPorMatricula($matricula);
    }else{
        $nuevo_coche = true;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Trabajo</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .error { color: red; }
        .exito { color: green; }
    </style>
</head>
<body>
    <h1>Panel de <?php echo $empleado->rol; ?></h1>
    <p>Bienvenido/a: <?php echo $empleado->nombre; ?> 
    <a href="logout.php">Cerrar Sesión</a> | <a href="menu.php">Volver al menú</a></p>
    <hr>
    
    <h2>Registrar Trabajo</h2>
    
    <?php
    if(!empty($errores)){
        echo "<div class='error'>";
        echo "<h3>Errores encontrados:</h3>";
        echo "<ul>";
        foreach($errores as $error){
            echo "<li>$error</li>";
        }
        echo "</ul>";
        echo "</div><br>";
    }
    
    if(isset($_SESSION['mensaje'])){
        echo "<div class='exito'><p>" . $_SESSION['mensaje'] . "</p></div>";
        unset($_SESSION['mensaje']);
    }
    ?>
    
    <?php if(!$cliente): ?>
        <!-- PASO 1: Buscar cliente por DNI -->
        <form action="" method="POST">
            <table>
                <tr>
                    <th colspan="2">Paso 1: Buscar Cliente</th>
                </tr>
                <tr>
                    <td><label>DNI del Cliente:</label></td>
                    <td><input type="text" name="dni" placeholder="12345678A" required></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" name="buscar_cliente" value="Buscar Cliente"></td>
                </tr>
            </table>
        </form>
    
    <?php elseif($cliente && !$coche_seleccionado && !$nuevo_coche): ?>
        <!-- PASO 2: Seleccionar coche o crear nuevo -->
        <h3>Paso 2: Seleccionar Vehículo</h3>
        <p><strong>Cliente encontrado:</strong> <?php echo isset($cliente->nombrecompleto) ? $cliente->nombrecompleto : 'Sin nombre'; ?> (DNI: <?php echo $cliente->dni; ?>)</p>
        
        <?php if($coches): ?>
            <h4>Vehículos registrados a nombre del cliente:</h4>
            <table>
                <tr>
                    <th>Matrícula</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Kilómetros</th>
                    <th>Acción</th>
                </tr>
                <?php foreach($coches as $c): ?>
                <tr>
                    <td><?php echo $c->matricula; ?></td>
                    <td><?php echo $c->marca; ?></td>
                    <td><?php echo $c->modelo; ?></td>
                    <td><?php echo $c->km; ?></td>
                    <td>
                        <form action="" method="POST" style="display:inline;">
                            <input type="hidden" name="dni_cliente" value="<?php echo $cliente->dni; ?>">
                            <input type="hidden" name="matricula_sel" value="<?php echo $c->matricula; ?>">
                            <input type="submit" name="seleccionar_coche" value="Seleccionar">
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
            <br>
        <?php else: ?>
            <p>No hay vehículos registrados para este cliente.</p>
        <?php endif; ?>
        
        <form action="" method="POST">
            <input type="hidden" name="dni_cliente" value="<?php echo $cliente->dni; ?>">
            <input type="submit" name="nuevo_coche" value="Registrar Nuevo Vehículo">
        </form>
        <br>
        <form action="" method="POST">
            <input type="submit" name="buscar_cliente" value="Buscar Otro Cliente">
        </form>
    
    <?php else: ?>
        <!-- PASO 3: Formulario completo de registro -->
        <h3>Paso 3: Registrar Trabajo</h3>
        
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="dni_cliente" value="<?php echo $cliente->dni; ?>">
            <input type="hidden" name="es_nuevo_coche" value="<?php echo $nuevo_coche ? '1' : '0'; ?>">
            <?php if($coche_seleccionado): ?>
                <input type="hidden" name="foto_actual" value="<?php echo $coche_seleccionado->foto; ?>">
            <?php endif; ?>
            
            <!-- TABLA: Datos del Cliente -->
            <table>
                <tr>
                    <th colspan="2">Datos del Cliente</th>
                </tr>
                <tr>
                    <td><label>DNI:</label></td>
                    <td><input type="text" name="dni_cliente" value="<?php echo $cliente->dni; ?>" readonly></td>
                </tr>
                <tr>
                    <td><label>Nombre Completo:</label></td>
                    <td><input type="text" name="nombre_cliente" value="<?php echo isset($cliente->nombrecompleto) ? $cliente->nombrecompleto : ''; ?>" required></td>
                </tr>
                <tr>
                    <td><label>Dirección:</label></td>
                    <td><input type="text" name="direccion_cliente" value="<?php echo $cliente->direccion; ?>" required></td>
                </tr>
                <tr>
                    <td><label>Teléfono:</label></td>
                    <td><input type="text" name="telf_cliente" value="<?php echo $cliente->telf; ?>" required></td>
                </tr>
            </table>
            
            <!-- TABLA: Datos del Vehículo -->
            <table>
                <tr>
                    <th colspan="2">Datos del Vehículo</th>
                </tr>
                <tr>
                    <td><label>Matrícula:</label></td>
                    <td><input type="text" name="matricula" value="<?php echo $coche_seleccionado ? $coche_seleccionado->matricula : ''; ?>" <?php echo !$nuevo_coche ? 'readonly' : ''; ?> required></td>
                </tr>
                <tr>
                    <td><label>Marca:</label></td>
                    <td><input type="text" name="marca" value="<?php echo $coche_seleccionado ? $coche_seleccionado->marca : ''; ?>" required></td>
                </tr>
                <tr>
                    <td><label>Modelo:</label></td>
                    <td><input type="text" name="modelo" value="<?php echo $coche_seleccionado ? $coche_seleccionado->modelo : ''; ?>" required></td>
                </tr>
                <tr>
                    <td><label>Kilómetros:</label></td>
                    <td><input type="number" name="km" value="<?php echo $coche_seleccionado ? $coche_seleccionado->km : ''; ?>" required></td>
                </tr>
                <tr>
                    <td><label>Foto del Vehículo (.jpg):</label></td>
                    <td>
                        <input type="file" name="foto" accept=".jpg">
                        <?php if($coche_seleccionado && $coche_seleccionado->foto): ?>
                            <br><small>Foto actual: <?php echo $coche_seleccionado->foto; ?></small>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
            
            <!-- TABLA: Tareas a Realizar -->
            <table>
                <tr>
                    <th colspan="2">Tareas a Realizar</th>
                </tr>
                <?php
                $tipos = array();
                foreach($tareas as $t){
                    if(!in_array($t->tipo, $tipos)){
                        $tipos[] = $t->tipo;
                    }
                }
                
                foreach($tipos as $tipo){
                    echo "<tr>";
                    echo "<td colspan='2'><strong>$tipo:</strong></td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td colspan='2'>";
                    echo "<select name='tareas[]' multiple size='5' style='width:100%;'>";
                    foreach($tareas as $t){
                        if($t->tipo == $tipo){
                            echo "<option value='" . $t->id . "'>" . $t->descripcion . " - " . $t->precio . "€</option>";
                        }
                    }
                    echo "</select>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
            
            <!-- TABLA: Mecánico Responsable -->
            <table>
                <tr>
                    <th colspan="2">Mecánico Responsable</th>
                </tr>
                <tr>
                    <td><label>Seleccione el mecánico:</label></td>
                    <td>
                        <select name="cod_mecanico" required>
                            <option value="">-- Seleccione un mecánico --</option>
                            <?php foreach($mecanicos as $m): ?>
                                <option value="<?php echo $m->codigo; ?>"><?php echo $m->nombre; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
            </table>
            
            <!-- Botones -->
            <table>
                <tr>
                    <td colspan="2" style="text-align: center;">
                        <input type="submit" name="registrar" value="Registrar Trabajo" style="padding: 10px 20px;">
                        <input type="submit" name="volver" value="Volver" style="padding: 10px 20px;">
                    </td>
                </tr>
            </table>
        </form>
    <?php endif; ?>
</body>
</html>