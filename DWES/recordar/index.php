<?php
require_once "funciones.php";
$mensaje = "";
$user = "";
$password = "";
$ultimo_acceso = "";


if(isset($_POST['acceder'])){
    $user = $_POST['user'];
    $password = $_POST['password'];
    $recuerdame = isset($_POST['recuerdame']);

    $connection = getConexion();
    $stmt = $connection -> prepare("SELECT * FROM jugadores WHERE nombre = ? AND equipo = ?");
    $stmt -> bind_param("ss", $user,$password); 
    $stmt -> execute();

    $result = $stmt -> get_result();

    if($result->num_rows >0){
        // checkbox correcto
        if($recuerdame){
            setcookie("user",$user);
            setcookie("password",$password);
            setcookie("ultimo_acceso",date("d-m-Y H:i:s"));
                        
        }else{
            setcookie("user","");
            setcookie("password","");
            setcookie("ultimo_acceso","");
        }
    }else{
        $mensaje = "Usuario y/o contrasena erroneos";
        echo $mensaje;
    }

}

// Mostrar cookies si existen
$user = isset($_COOKIE['user']) ? $_COOKIE['user'] : "";
$password = isset($_COOKIE['password']) ? $_COOKIE['password'] : "";
$ultimo_acceso = isset($_COOKIE['ultimo_acceso']) ? $_COOKIE['ultimo_acceso'] : "";

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recordar usuario</title>
</head>
<body>
    <form method="POST" action="">
        Usuario <input type="text" name="user"><br>
        Contraseña <input type="password" name="password"><br>
        Recuerdame<input type="checkbox" name="recuerdame" <?php echo $user ? "checked" : ""; ?>><br>
        <input type="submit" value="Acceder" name="acceder">
    </form>

<?php if ($ultimo_acceso): ?>
    <p>Último acceso: <?php echo $ultimo_acceso; ?></p>
<?php endif; ?>

<?php if ($mensaje): ?>
    <p style="color:red;"><?php echo $mensaje; ?></p>
<?php endif; ?>

</body>
</html>