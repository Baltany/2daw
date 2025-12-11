<?php
// REGISTRO - Cifrar contraseña con MD5
$pass_cifrada = md5($_POST['pass']);

// LOGIN - Comparar con MD5
$pass_input = md5($_POST['pass']);
$result = $conex->query("SELECT * FROM usuarios WHERE email='$email' AND pass='$pass_input'");
?>