<?php
function getConnection(){
    try{
        $connection = new mysqli("localhost","dwes","abc123.","tema4_logueo");
        $connection ->set_charset("utf8mb4");
        return $connection;
    }catch(mysqli_sql_exception $e){
        echo $e->getMessage();
    }

}

// comprobamos si el usuario existe ya o no existe
function existeUsuario($user){
    $connection = getConnection();
    $stmt = $connection -> prepare("SELECT * FROM perfil_usuario WHERE user = ?");
    $stmt -> bind_param("s",$user);
    $stmt -> execute();
    $result = $stmt->get_result();
    $stmt -> close();
    return $result -> num_rows > 0 ? $result->fetch_object() : null;
}

function registrarUsuario($nombre,$apellidos,$direccion,$localidad,$user,$pass,$color_letra,$color_fondo,$tipo_letra,$tam_letra){
    $connection = getConnection();
    $pass_hash = md5($pass);
    $stmt = $connection -> prepare("INSERT INTO perfil_usuario (nombre, apellidos, direccion, localidad, user, pass, color_letra, color_fondo, tipo_letra, tam_letra) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt -> bind_param("sssssssssi", $nombre, $apellidos, $direccion, $localidad, $user, $pass_hash, $color_letra, $color_fondo, $tipo_letra, $tam_letra);

    if($stmt -> execute()){
        $stmt->close();
        return true;

    }else{
        $stmt -> close();
        return false;
    }
}

function modificarUsuario($nombre,$apellidos,$direccion,$localidad,$user,$color_letra,$color_fondo,$tipo_letra,$tam_letra){
    $connection = getConnection();
    $stmt = $connection -> prepare("UPDATE perfil_usuario SET nombre = ?, apellidos = ?, direccion = ?, localidad = ?, color_letra = ?, color_fondo = ?, tipo_letra = ?, tam_letra = ? WHERE user = ?");
    $stmt->bind_param("sssssssis", $nombre, $apellidos, $direccion, $localidad, $color_letra, $color_fondo, $tipo_letra, $tam_letra, $user);
    
    if($stmt -> execute()){
        $stmt->close();
        return true;
    }else{
        return false;
    }
}

function getUsuarioUser($user){
    $connection = getConnection();
    $stmt = $connection -> prepare("SELECT * FROM perfil_usuario WHERE user = ?");
    $stmt -> bind_param("s",$user);
    $stmt -> execute();
    $result = $stmt -> get_result();
    $stmt -> close();
    return $result->fetch_object();
}

?>