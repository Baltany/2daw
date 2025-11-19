<!-- se puede crear un buffer con ob_start() set_cookie("","") y terminamos el buffer que se manda en la cabecera para que no se llene el buffer ob_end_flush() -->
<?php 
// hacer una pagina que cuando yo la cargue diga bienvenido el tiempo y la hora del ultimo acceso
setcookie("fecha", time());
if (isset($_COOKIE['cookie'])) {
    echo "primera vez";
}else{
    echo date("");
}

?>