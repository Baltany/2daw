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


<!-- Mostrar la matriz -->

<?php
$matriz = array(
    "Marketing" => array(
        "nombre" => "pepe",
        "apellidos" => "López",
        "Salario" => 1500,
        "Edad" => 35
    ),
    "Contabilidad" => array(
        "nombre" => "Juan"
    )
);

?>