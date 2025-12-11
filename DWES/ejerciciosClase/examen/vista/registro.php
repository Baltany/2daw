<?php
session_start();
if(isset($_COOKIE['usuario_id'])){
    header("Location:index.php");
}

require_once '../model/Usuario.php';
require_once '../controller/UsuarioController.php';

if(isset($_POST['registrar'])){
    $errores=array();
    
    $dni=trim($_POST['dni']);
    $nombre=trim($_POST['nombre']);
    $apellidos=trim($_POST['apellidos']);
    $email=trim($_POST['email']);
    $password=$_POST['password'];
    $confirm_password=$_POST['confirm_password'];
    $provincia=$_POST['provincia'];
    $sexo=isset($_POST['sexo']) ? $_POST['sexo'] : '';
    $edad=isset($_POST['edad']) ? $_POST['edad'] : 0;
    $estado_civil=$_POST['estado_civil'];
    $aficiones=isset($_POST['aficiones']) ? implode(', ',$_POST['aficiones']) : '';
    $estudios=isset($_POST['estudios']) ? implode(', ',$_POST['estudios']) : '';
    
    if(empty($dni) || !preg_match('/^[0-9]{8}[A-Z]$/',$dni)){
        $errores[]="El DNI debe tener 8 números y una letra mayúscula";
    }
    
    if(empty($nombre)){
        $errores[]="El nombre es obligatorio";
    }
    
    if(empty($apellidos)){
        $errores[]="Los apellidos son obligatorios";
    }
    
    if(empty($email) || !filter_var($email,FILTER_VALIDATE_EMAIL)){
        $errores[]="El email no es válido";
    }
    
    if(strlen($password)<6){
        $errores[]="La contraseña debe tener al menos 6 caracteres";
    }
    
    if($password!==$confirm_password){
        $errores[]="Las contraseñas no coinciden";
    }
    
    if(empty($errores)){
        if(usuarioController::buscarPorDni($dni)){
            $errores[]="El DNI ya está registrado";
        }
        if(usuarioController::buscarPorEmail($email)){
            $errores[]="El email ya está registrado";
        }
    }
    
    if(empty($errores)){
        $password_hash=password_hash($password,PASSWORD_DEFAULT);
        $u=new Usuario(0,$dni,$nombre,$apellidos,$email,$password_hash,$provincia,$sexo,$edad,$estado_civil,$aficiones,$estudios);
        
        if(usuarioController::insertar($u)){
            echo "<br>Registro exitoso. Puedes iniciar sesión<br>";
            echo "<a href='login.php'>Ir a login</a>";
        }else{
            $errores[]="Error al registrar el usuario";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
</head>
<body>
    <h1>Registro de Usuario</h1>
    
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
    
    <form method="POST" action="">
        <h2>Datos Personales</h2>
        
        DNI: <input type="text" name="dni" pattern="[0-9]{8}[A-Z]" placeholder="12345678A" required 
               value="<?php echo isset($_POST['dni']) ? $_POST['dni'] : ''; ?>"><br><br>
        
        Nombre: <input type="text" name="nombre" required minlength="2"
               value="<?php echo isset($_POST['nombre']) ? $_POST['nombre'] : ''; ?>"><br><br>
        
        Apellidos: <input type="text" name="apellidos" required minlength="2"
               value="<?php echo isset($_POST['apellidos']) ? $_POST['apellidos'] : ''; ?>"><br><br>
        
        Email: <input type="email" name="email" required
               value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>"><br><br>
        
        Contraseña: <input type="password" name="password" required minlength="6"><br><br>
        
        Confirmar Contraseña: <input type="password" name="confirm_password" required minlength="6"><br><br>
        
        <h2>Información Adicional</h2>
        
        Provincia: <select name="provincia">
            <option value="">Seleccione una provincia</option>
            <option value="Malaga" <?php echo (isset($_POST['provincia']) && $_POST['provincia'] == 'Malaga') ? 'selected' : ''; ?>>Málaga</option>
            <option value="Cordoba" <?php echo (isset($_POST['provincia']) && $_POST['provincia'] == 'Cordoba') ? 'selected' : ''; ?>>Córdoba</option>
            <option value="Jaen" <?php echo (isset($_POST['provincia']) && $_POST['provincia'] == 'Jaen') ? 'selected' : ''; ?>>Jaén</option>
            <option value="Almeria" <?php echo (isset($_POST['provincia']) && $_POST['provincia'] == 'Almeria') ? 'selected' : ''; ?>>Almería</option>
            <option value="Sevilla" <?php echo (isset($_POST['provincia']) && $_POST['provincia'] == 'Sevilla') ? 'selected' : ''; ?>>Sevilla</option>
            <option value="Granada" <?php echo (isset($_POST['provincia']) && $_POST['provincia'] == 'Granada') ? 'selected' : ''; ?>>Granada</option>
            <option value="Cadiz" <?php echo (isset($_POST['provincia']) && $_POST['provincia'] == 'Cadiz') ? 'selected' : ''; ?>>Cádiz</option>
            <option value="Huelva" <?php echo (isset($_POST['provincia']) && $_POST['provincia'] == 'Huelva') ? 'selected' : ''; ?>>Huelva</option>
        </select><br><br>
        
        Sexo: 
        <input type="radio" name="sexo" value="Hombre" <?php echo (isset($_POST['sexo']) && $_POST['sexo'] == 'Hombre') ? 'checked' : ''; ?>> Hombre
        <input type="radio" name="sexo" value="Mujer" <?php echo (isset($_POST['sexo']) && $_POST['sexo'] == 'Mujer') ? 'checked' : ''; ?>> Mujer
        <input type="radio" name="sexo" value="Otro" <?php echo (isset($_POST['sexo']) && $_POST['sexo'] == 'Otro') ? 'checked' : ''; ?>> Otro<br><br>
        
        Edad: <input type="number" name="edad" min="18" max="120"
               value="<?php echo isset($_POST['edad']) ? $_POST['edad'] : ''; ?>"><br><br>
        
        Estado Civil: <select name="estado_civil">
            <option value="">Seleccione</option>
            <option value="Soltero" <?php echo (isset($_POST['estado_civil']) && $_POST['estado_civil'] == 'Soltero') ? 'selected' : ''; ?>>Soltero/a</option>
            <option value="Casado" <?php echo (isset($_POST['estado_civil']) && $_POST['estado_civil'] == 'Casado') ? 'selected' : ''; ?>>Casado/a</option>
            <option value="Divorciado" <?php echo (isset($_POST['estado_civil']) && $_POST['estado_civil'] == 'Divorciado') ? 'selected' : ''; ?>>Divorciado/a</option>
            <option value="Viudo" <?php echo (isset($_POST['estado_civil']) && $_POST['estado_civil'] == 'Viudo') ? 'selected' : ''; ?>>Viudo/a</option>
        </select><br><br>
        
        Aficiones:<br>
        <input type="checkbox" name="aficiones[]" value="Cine" <?php echo (isset($_POST['aficiones']) && in_array('Cine', $_POST['aficiones'])) ? 'checked' : ''; ?>> Cine
        <input type="checkbox" name="aficiones[]" value="Deporte" <?php echo (isset($_POST['aficiones']) && in_array('Deporte', $_POST['aficiones'])) ? 'checked' : ''; ?>> Deporte
        <input type="checkbox" name="aficiones[]" value="Lectura" <?php echo (isset($_POST['aficiones']) && in_array('Lectura', $_POST['aficiones'])) ? 'checked' : ''; ?>> Lectura
        <input type="checkbox" name="aficiones[]" value="Musica" <?php echo (isset($_POST['aficiones']) && in_array('Musica', $_POST['aficiones'])) ? 'checked' : ''; ?>> Música
        <input type="checkbox" name="aficiones[]" value="TV" <?php echo (isset($_POST['aficiones']) && in_array('TV', $_POST['aficiones'])) ? 'checked' : ''; ?>> TV
        <input type="checkbox" name="aficiones[]" value="Viajar" <?php echo (isset($_POST['aficiones']) && in_array('Viajar', $_POST['aficiones'])) ? 'checked' : ''; ?>> Viajar<br><br>
        
        Estudios:<br>
        <select name="estudios[]" multiple size="8">
            <option value="ESO" <?php echo (isset($_POST['estudios']) && in_array('ESO', $_POST['estudios'])) ? 'selected' : ''; ?>>ESO</option>
            <option value="Bachillerato" <?php echo (isset($_POST['estudios']) && in_array('Bachillerato', $_POST['estudios'])) ? 'selected' : ''; ?>>Bachillerato</option>
            <option value="CFGM" <?php echo (isset($_POST['estudios']) && in_array('CFGM', $_POST['estudios'])) ? 'selected' : ''; ?>>CFGM</option>
            <option value="CFGS" <?php echo (isset($_POST['estudios']) && in_array('CFGS', $_POST['estudios'])) ? 'selected' : ''; ?>>CFGS</option>
            <option value="Universidad" <?php echo (isset($_POST['estudios']) && in_array('Universidad', $_POST['estudios'])) ? 'selected' : ''; ?>>Universidad</option>
            <option value="Postgrado" <?php echo (isset($_POST['estudios']) && in_array('Postgrado', $_POST['estudios'])) ? 'selected' : ''; ?>>Postgrado</option>
            <option value="Master" <?php echo (isset($_POST['estudios']) && in_array('Master', $_POST['estudios'])) ? 'selected' : ''; ?>>Máster</option>
            <option value="Doctorado" <?php echo (isset($_POST['estudios']) && in_array('Doctorado', $_POST['estudios'])) ? 'selected' : ''; ?>>Doctorado</option>
        </select><br><br>
        
        <input type="submit" name="registrar" value="Registrarse">
    </form>
    
    <p><a href="login.php">¿Ya tienes cuenta? Inicia sesión</a></p>
</body>
</html>
