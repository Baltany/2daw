<!-- Traer una variable superglobal y mostrarla en una tabla -->
<table>
<?php
foreach($_SERVER as $key => $value){
    echo "<tr>";
}
?>
</table>