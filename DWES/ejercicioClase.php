<!-- Traer una variable superglobal y mostrarla en una tabla -->
<table border="1">
    <tr>
        <th>Índice</th>
        <th>Valor</th>
    </tr>
<?php
foreach($_SERVER as $key => $value){
    echo "<tr><td>" . $key . "</td><td>".$value."</td></tr>";
}
?>
</table>