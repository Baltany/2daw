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
        "nombre" => "Pepe",
        "apellidos" => "López",
        "Salario" => 1500,
        "Edad" => 35
    ),
    "Dirección" => array(
        "nombre" => "Juan",
        "apellidos" => "López",
        "Salario" => 1000,
        "Edad" => 46
    ),
    "Contabilidad" => array(
        "nombre" => "Jose",
        "apellidos" => "López",
        "Salario" => 1500,
        "Edad" => 35
    ),
    "Ventas" => array(
        "nombre" => "Antonio",
        "apellidos" => "López",
        "Salario" => 1900,
        "Edad" => 50
    ),
    "Información" => array(
        "nombre" => "Pedro",
        "apellidos" => "López",
        "Salario" => 1800,
        "Edad" => 38
    )
);
echo "<br>";

echo "<table border='1'>";
echo "<tr>";
echo "<th> </th>";
foreach ($matriz["Ventas"] as $clave=>$valor){
    echo "<th>";
    echo $clave;
    echo "</th>";
}
echo "</tr>";


foreach($matriz as $clave=>$fila){
    echo "<tr>";
    echo "<th>". $clave ."</th>";
    foreach($fila as $valor){
        echo "<td>";
        echo $valor;
        echo "</td>";
        

    }
    echo "</tr>";
}

echo "</table>"

?>