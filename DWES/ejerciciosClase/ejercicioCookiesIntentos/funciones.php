<?php
function getConnection(){

    try{
        $connection = new mysqli("localhost","dwes","abc123.","usuarios_db");
        $connection -> set_charset("utf8mb4");
        return $connection;
    }catch(mysqli_sql_exception $e){
        return $e->getMessage();
    }
}

// comprobamos que el usuario que 
// se va a registrar no está ya previamente registrado
function existeUsuario($email){
    $connection = getConnection();
    $stmt = $connection -> prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt -> bind_param("s",$email);
    $stmt -> execute();
    $result = $stmt -> get_result();
    $stmt -> close();
    // En el caso q hayan datos se recupera el objeto con un fetch,
    // sino devuelve null
    return $result -> num_rows > 0 ? $result->fetch_object() : null;
}


// registramos el usuario sino existe
function registrarUsuario($dni,$nombre,$apellidos,$email,$pass){
    $connection = getConnection();
    // hardcodeamos la pass
    $pass_hash = password_hash($pass,PASSWORD_DEFAULT);
    $stmt = $connection -> prepare("INSERT INTO usuarios(DNI,Nombre,Apellidos,email,pass) VALUES (?,?,?,?,?)");
    $stmt -> bind_param("sssss",$dni,$nombre,$apellidos,$email,$pass_hash);
    if($stmt ->execute()){
        $stmt->close();
        return true;

    }else{
        $stmt->close();
        return false;
    }
}

// actualizar ultimo acceso del usuario
function actualizarUltimoAcceso($email){
    $connection = getConnection();
    $fechaActual = date("Y-m-d H:i:s");
    $stmt = $connection->prepare("UPDATE usuarios SET ultimo_acceso = ? WHERE email = ?");
    $stmt->bind_param("ss", $fechaActual, $email);
    $stmt->execute();

}





?>

