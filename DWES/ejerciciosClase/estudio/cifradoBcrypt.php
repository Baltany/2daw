<?php
// ============================================
// BCRYPT - ALTERNATIVA SEGURA A MD5
// ============================================

// REGISTRO - Cifrar con bcrypt
$pass_cifrada = password_hash($_POST['pass'], PASSWORD_DEFAULT);
// Resultado: $2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcfl7p92ldGxad68LJZdL17lhWy

// LOGIN - Verificar con bcrypt
$result = $conex->query("SELECT * FROM usuarios WHERE email='$email'");
if($result->num_rows){
    $usuario = $result->fetch_object();
    // Verificar contraseña
    if(password_verify($_POST['pass'], $usuario->pass)){
        // Login correcto
    }else{
        // Contraseña incorrecta
    }
}

// NOTA: Con bcrypt NO se puede hacer WHERE pass='...' en la consulta
// Hay que obtener el usuario primero y luego verificar con password_verify()
?>

<?php
// ============================================
// BCRYPT - ALTERNATIVA SEGURA A MD5
// ============================================

// REGISTRO - Cifrar con bcrypt
$pass_cifrada = password_hash($_POST['pass'], PASSWORD_DEFAULT);
// Resultado: $2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcfl7p92ldGxad68LJZdL17lhWy

// LOGIN - Verificar con bcrypt
$result = $conex->query("SELECT * FROM usuarios WHERE email='$email'");
if($result->num_rows){
    $usuario = $result->fetch_object();
    // Verificar contraseña
    if(password_verify($_POST['pass'], $usuario->pass)){
        // Login correcto
    }else{
        // Contraseña incorrecta
    }
}

// NOTA: Con bcrypt NO se puede hacer WHERE pass='...' en la consulta
// Hay que obtener el usuario primero y luego verificar con password_verify()
?>