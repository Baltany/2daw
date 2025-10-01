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
?>

