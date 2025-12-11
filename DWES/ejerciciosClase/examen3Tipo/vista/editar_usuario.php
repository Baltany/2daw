<?php
session_start();

if(!isset($_COOKIE['usuario_id']) || empty($_COOKIE['usuario_id'])){
    header("Location: login.php");
    exit();
}

require_once '../model/Usuario.php';
require_once '../controller/UsuarioController.php';

$usuario_logueado = UsuarioController::buscarPorId($_COOKIE['usuario_id']);

if(!$usuario_logueado || !$usuario_logueado->esAdmin()){
    header("Location: index.php");
    exit();
}

if(!isset($_GET['id'])){
    header("Location: admin.php");
    exit();
}

$usuario = UsuarioController::buscarPorId($_GET['id']);
if(!$usuario){
    echo "Usuario no encontrado";
    echo "<a href='admin.php'>Volver</a>";
    exit();
}

if(isset($_POST['actualizar'])){
    $errores = array();
    
    $id = $_POST['id'];
    $dni = trim($_POST['dni']);
    $nombre = trim($_POST['nombre']);
    $apellidos = trim($_POST['apellidos']);
    $email = trim($_POST['email']);
    $provincia = $_POST['provincia'];
    $sexo = isset($_POST['sexo']) ? $_POST['sexo'] : '';
    $edad = isset($_POST['edad']) ? $_POST['edad'] : 0;
    $estado_civil = $_POST['estado_civil'];
    // pasamos con el implode lo que recojamos a cadena de texto para la bbdd
    $aficiones = isset($_POST['aficiones']) ? implode(', ', $_POST['aficiones']) : '';
    $estudios = isset($_POST['estudios']) ? implode(', ', $_POST['estudios']) : '';
    $tipo = $_POST['tipo'];
    
    if(empty($dni) || !preg_match('/^[0-9]{8}[A-Z]$/', $dni)){
        $errores[] = "El DNI debe tener 8 números y una letra mayúscula";
    }
    
    if(empty($nombre)){
        $errores[] = "El nombre es obligatorio";
    }
    
    if(empty($apellidos)){
        $errores[] = "Los apellidos son obligatorios";
    }
    
    if(empty($email) || !preg_match('/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/', $email)){
        $errores[] = "El email no es válido";
    }
    
    // Validar que el DNI no esté siendo usado por otro usuario
    if(empty($errores)){
        $usuario_dni = UsuarioController::buscarPorDni($dni);
        if($usuario_dni && $usuario_dni->id != $id){
            $errores[] = "El DNI ya está registrado por otro usuario";
        }
    }
    
    // Validar que el email no esté siendo usado por otro usuario
    if(empty($errores)){
        $usuario_email = UsuarioController::buscarPorEmail($email);
        if($usuario_email && $usuario_email->id != $id){
            $errores[] = "El email ya está registrado por otro usuario";
        }
    }
    
    if(empty($errores)){
        $u = new Usuario(
            $id,
            $dni,
            $nombre,
            $apellidos,
            $email,
            $usuario->password, // Mantener la contraseña actual
            $provincia,
            $sexo,
            $edad,
            $estado_civil,
            $aficiones,
            $estudios,
            $usuario->fecha_registro, // Mantener fecha de registro
            $tipo
        );
        
        if(UsuarioController::actualizar($u)){
            $mensaje_exito = "<p style='color:green;'>Usuario actualizado correctamente</p>";
            // Recargar los datos actualizados
            $usuario = UsuarioController::buscarPorId($id);
        } else {
            $errores[] = "Error al actualizar el usuario";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
</head>
<body>
    <h1>Editar Usuario</h1>
    
    <p>Administrador: <?php echo $usuario_logueado->nombre . ' ' . $usuario_logueado->apellidos; ?></p>
    
    <a href="admin.php">Volver a Administración</a> | 
    <a href="index.php">Panel Principal</a> | 
    <a href="logout.php">Cerrar Sesión</a>
    
    <hr>
    
    <?php if(isset($mensaje_exito)) echo $mensaje_exito; ?>
    
    <?php if(isset($errores) && !empty($errores)): ?>
        <div style="color:red;">
            <h3>Errores:</h3>
            <ul>
                <?php foreach($errores as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <h2>Datos del Usuario</h2>
    
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?php echo $usuario->id; ?>">
        
        <h3>Datos Personales</h3>
        
        DNI: <input type="text" name="dni" pattern="[0-9]{8}[A-Z]" placeholder="12345678A" required 
               value="<?php echo isset($_POST['dni']) ? $_POST['dni'] : $usuario->dni; ?>"><br><br>
        
        Nombre: <input type="text" name="nombre" required minlength="2"
               value="<?php echo isset($_POST['nombre']) ? $_POST['nombre'] : $usuario->nombre; ?>"><br><br>
        
        Apellidos: <input type="text" name="apellidos" required minlength="2"
               value="<?php echo isset($_POST['apellidos']) ? $_POST['apellidos'] : $usuario->apellidos; ?>"><br><br>
        
        Email: <input type="email" name="email" required
               value="<?php echo isset($_POST['email']) ? $_POST['email'] : $usuario->email; ?>"><br><br>
        
        <h3>Información Adicional</h3>
        
        Provincia: <select name="provincia">
            <option value="">Seleccione una provincia</option>
            <?php 
            $provincias = array('Malaga','Cordoba','Jaen','Almeria','Sevilla','Granada','Cadiz','Huelva');
            $prov_seleccionada = isset($_POST['provincia']) ? $_POST['provincia'] : $usuario->provincia;
            foreach($provincias as $p){
                $selected = ($prov_seleccionada == $p) ? 'selected' : '';
                echo "<option value='$p' $selected>$p</option>";
            }
            ?>
        </select><br><br>
        
        Sexo: 
        <?php $sexo_seleccionado = isset($_POST['sexo']) ? $_POST['sexo'] : $usuario->sexo; ?>
        <input type="radio" name="sexo" value="Hombre" <?php echo ($sexo_seleccionado == 'Hombre') ? 'checked' : ''; ?>> Hombre
        <input type="radio" name="sexo" value="Mujer" <?php echo ($sexo_seleccionado == 'Mujer') ? 'checked' : ''; ?>> Mujer
        <input type="radio" name="sexo" value="Otro" <?php echo ($sexo_seleccionado == 'Otro') ? 'checked' : ''; ?>> Otro<br><br>
        
        Edad: <input type="number" name="edad" min="18" max="120"
               value="<?php echo isset($_POST['edad']) ? $_POST['edad'] : $usuario->edad; ?>"><br><br>
        
        Estado Civil: <select name="estado_civil">
            <?php
            $estados = array(''=>'Seleccione','Soltero'=>'Soltero/a','Casado'=>'Casado/a','Divorciado'=>'Divorciado/a','Viudo'=>'Viudo/a');
            $estado_seleccionado = isset($_POST['estado_civil']) ? $_POST['estado_civil'] : $usuario->estado_civil;
            foreach($estados as $valor => $texto){
                $selected = ($estado_seleccionado == $valor) ? 'selected' : '';
                echo "<option value='$valor' $selected>$texto</option>";
            }
            ?>
        </select><br><br>
        
        Aficiones:<br>
        <?php
        $aficiones_usuario = explode(', ', $usuario->aficiones);
        $aficiones_disponibles = array('Cine','Deporte','Lectura','Musica','TV','Viajar');
        foreach($aficiones_disponibles as $af){
            $checked = (isset($_POST['aficiones']) && in_array($af, $_POST['aficiones'])) || 
                       (!isset($_POST['aficiones']) && in_array($af, $aficiones_usuario)) ? 'checked' : '';
            echo "<input type='checkbox' name='aficiones[]' value='$af' $checked> $af ";
        }
        ?>
        <br><br>
        
        Estudios:<br>
        <select name="estudios[]" multiple size="8">
            <?php
            $estudios_usuario = explode(', ', $usuario->estudios);
            $estudios_disponibles = array('ESO','Bachillerato','CFGM','CFGS','Universidad','Postgrado','Master','Doctorado');
            foreach($estudios_disponibles as $est){
                $selected = (isset($_POST['estudios']) && in_array($est, $_POST['estudios'])) || 
                            (!isset($_POST['estudios']) && in_array($est, $estudios_usuario)) ? 'selected' : '';
                echo "<option value='$est' $selected>$est</option>";
            }
            ?>
        </select><br><br>
        
        <h3>Tipo de Usuario</h3>
        
        Tipo: <select name="tipo" required>
            <?php
            $tipo_seleccionado = isset($_POST['tipo']) ? $_POST['tipo'] : $usuario->tipo;
            ?>
            <option value="Cliente" <?php echo ($tipo_seleccionado == 'Cliente') ? 'selected' : ''; ?>>Cliente</option>
            <option value="admin" <?php echo ($tipo_seleccionado == 'admin') ? 'selected' : ''; ?>>Administrador</option>
        </select><br><br>
        

        
        <input type="submit" name="actualizar" value="Actualizar Usuario">
    </form>
</body>
</html>