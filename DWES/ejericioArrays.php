<!--  https://www.php.net/manual/es/ref.array.php documentasion
• Objetivo: Practicar la creación y acceso a elementos de un array. 
• Descripción: 
1. Crea un array llamado $colores que contenga los colores "rojo", 
"verde", "azul", "amarillo". 
2. Muestra el primer y el tercer elemento del array. 
3. Agrega un nuevo color "naranja" al array. 
4. Muestra todos los elementos del array usando un bucle for.  -->
<?php
$colores = array("rojo","verde","asul","amarillo");
echo "<br>";
echo "<br>";
echo "Color 1 ".$colores[0] ." Color 3 ".$colores[2];
$colores[] = "naranja";
//array_push($colores,"naranja");
echo "<br>";
echo "<br>";

echo "Remostrando la lista";
echo "<br>";
echo "<br>";

var_dump($colores);

echo "<br>";
echo "<br>";
echo "Mostrando array usando un for: <br>";
echo "<br>";
foreach($colores as $color){
    echo $color . "<br>";
}

?>

<!-- 
• Objetivo: Practicar la creación y manipulación de arrays asociativos. 
• Descripción: 
1. Crea un array asociativo llamado $persona con las claves nombre, edad 
y ciudad. 
2. Asigna los valores "Juan", 25, y "Madrid" a estas claves, 
respectivamente. 
3. Muestra el nombre y la ciudad de la persona. 
4. Agrega una nueva clave profesion con el valor "Ingeniero" y muestra 
todos los datos.
-->
<?php
$persona = array("nombre"=> "Juan","edad"=>25,"ciudad"=> "Madrid");
echo "<br><br>";
echo "Nombre: ". $persona["nombre"] . " y ciudad ". $persona["ciudad"];
$persona["profesion"] = "Ingeniero";
echo "<br><br>";
var_dump($persona); 
echo "<br>";
echo "<br>";

?>


<!-- 
• Objetivo: Practicar la ordenación de arrays. 
• Descripción: 
1. Crea un array numérico llamado $numeros con los valores 3, 1, 4, 1, 5, 
9. 
2. Ordena el array en orden ascendente y muestra el resultado. 
3. Ordena el array en orden descendente y muestra el resultado.  -->
<?php
$numeros = array(3,1,4,1,5,9);
sort($numeros);
echo "Mostrando array ordenado" . "<br>";

var_dump($numeros);
echo "<br>";
echo "<br>";
echo "Mostrando array en orden acendente";
rsort($numeros);
var_dump($numeros);
echo "<br>";

?>

<!-- 
• Objetivo: Practicar el uso de la función count(). 
• Descripción: 
1. Crea un array llamado $animales con los valores "gato", "perro", 
"elefante", "jirafa". 
2. Muestra el número de elementos en el array. 
3. Añade dos animales más al array. 
4. Muestra el número actualizado de elementos.  -->
<?php
$animales = array("gato","perro","elefante","jirafa");
echo "nº animales en el array:".count($animales);
$animales[] = "uron";
$animales[] = "mono";
echo "<br>";
echo "nº animales actualizado en el array:".count($animales);
echo "<br>";
?>




