<?php
session_name("emp");
session_start();
session_unset();
session_destroy();

// Eliminar cookie si existe
if (isset($_COOKIE['emp'])) {
    setcookie("emp", "", time() - 3600, "/");
}

header("Location: login.php");
exit();