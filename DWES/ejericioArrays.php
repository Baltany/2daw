<!--  https://www.php.net/manual/es/ref.array.php documentasion
• Objetivo: Practicar la creación y acceso a elementos de un array. 
• Descripción: 
1. Crea un array llamado $colores que contenga los colores "rojo", 
"verde", "azul", "amarillo". 
2. Muestra el primer y el tercer elemento del array. 
3. Agrega un nuevo color "naranja" al array. 
4. Muestra todos los elementos del array usando un bucle for.  -->
<?php

use function PHPSTORM_META\elementType;

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

<!-- 
• Objetivo: Practicar la creación y acceso a elementos de un array 
multidimensional. 
• Descripción: 
1. Crea un array multidimensional llamado $productos que contenga tres 
arrays internos, cada uno representando un producto con nombre, precio 
y cantidad. 
2. Muestra el nombre y el precio del segundo producto. 
3. Muestra todos los productos con un bucle foreach.  -->
<?php
$productos = array(
    array("nombre" => "Leche","precio"=>2.3,"cantidad"=>1),
    array("nombre" => "Agua","precio"=>3,"cantidad"=>2),
    array("nombre" => "Galletas Oreo","precio"=>10,"cantidad"=>5)
);
echo "<br>";
echo "<br>";
echo "El nombre del 2º producto es ".$productos[2]["nombre"]. " y el precio es: ".$productos[2]["precio"];
echo "<br>";
echo "<br>";
echo "Mostrando productos con un foreach";
echo "<br>";

foreach ($productos as $clave=>$valor){
    echo "Producto ". ($clave + 1) . " Nombre: ". $valor["nombre"]. " precio: ".$valor["precio"]." y cantidad: ".$valor["cantidad"]."<br>";
}


echo "<br>";
echo "<br>";

?>
<!-- Ejercicio 6: Funciones de Arrays 
• Objetivo: Practicar el uso de funciones integradas para manipular arrays. 
• Descripción: 
1. Crea un array llamado $nombres con los valores "Ana", "Luis", "Carlos", 
"Maria". 
2. Usa la función array_reverse() para mostrar los nombres en orden 
inverso. 
3. Usa la función in_array() para comprobar si "Carlos" está en el array. 
4. Usa la función array_push() para agregar "Juan" al final del array y 
muestra el array actualizado. -->
<?php
$nombres = array("Ana","Luis","Carlos","Maria");
echo "Mostrando el array en orden inverso: <br>";
var_dump(array_reverse($nombres));
echo "<br>";
echo "<br>";
if(in_array("Carlos",$nombres)){
    echo "Carlos está en el array";
}else{
    echo "No existe";
    return;
}
echo "<br>";

array_push($nombres,"Juan");
echo "Array actualizado";
var_dump($nombres);

?>

<!-- • Objetivo: Practicar la eliminación de elementos de un array. 
• Descripción: 
1. Crea un array llamado $paises con los valores "España", "Francia", 
"Italia", "Alemania", "Portugal". 
2. Usa la función unset() para eliminar "Italia" del array. 
3. Muestra el array después de eliminar el elemento. 
4. Usa la función array_pop() para eliminar el último elemento del array y 
muestra el array actualizado. -->

<?php
echo "<br> <br>";
$paises = array("España","Francia","Italia","Alemania","Portugal");
// usamos el metodo para eliminar una array una posición que se le ordene
unset($paises[2]);
echo "Array sin Italia";
echo "<br> <br>";
var_dump($paises);
echo "<br> <br>";
// Para borrar el último elemento del array usamos el método pop
array_pop($paises);
echo "<br> <br>";
echo "Array sin el último elemento";
var_dump($paises);
?>

<!-- • Objetivo: Practicar la búsqueda de valores en un array. 
• Descripción: 
1. Crea un array numérico llamado $edades con los valores 20, 30, 40, 25, 
35. 
2. Usa la función array_search() para encontrar la posición de la edad 25 
en el array. 
3. Si el valor existe, muestra la posición, de lo contrario muestra un 
mensaje indicando que no se encontró.  -->
<?php
echo "<br> <br>";
$edades = array(20,30,40,25,35);
// recorre el array en busca de un caracter que se le indique
$posicion  = array_search(25,$edades);
if($posicion != false){
    echo "La posición de la edad 25 es: ". $posicion +1;
}else{
    echo "No se encontró la edad 25 en el array";
}
?>

<!-- • Objetivo: Implementar un algoritmo para encontrar el valor máximo y mínimo 
de un array sin usar las funciones integradas de PHP. 
• Descripción: 
1. Crea un array numérico con al menos 5 elementos. 
2. Escribe un algoritmo que recorra el array y determine el valor máximo y 
mínimo sin usar max() ni min(). 
3. Muestra el valor máximo y mínimo.  -->

<?php
echo "<br> <br>";

$numeros = array(10,20,5,30,15);
// Inicializamos el máximo y mínimo
$maximo = $numeros[0];
$minimo = $numeros[0];

foreach($numeros as $valor){
    if($valor > $maximo){
        $maximo = $valor;
    }
    if($valor < $minimo){
        $minimo = $valor;
    }
}

echo "El valor maximo es: " . $maximo . "<br>";
echo "El valor minimo es: " . $minimo . "<br>";
?>

<!-- Ejercicio 10: Contar las Vocales en una Cadena 
• Objetivo: Practicar el uso de bucles, operadores lógicos y funciones para 
manejar cadenas. 
• Descripción: 
1. Solicita una cadena de texto al usuario. 
2. Escribe un algoritmo que cuente cuántas vocales hay en la cadena. -->

<?php
echo "<br> <br>";
$cadena = "Lorem Ipsum es un texto de marcador de posicion utilizado comunmente en diseño grafico y tipografia";
function contarVocales($cadena){
    $vocales = array("a","e","i","o","u","A","E","I","O","U");
    $contador = 0;

    // usamo el split para poder convertirlo en array y podamos recorrerlo posteriormente con un foreach
    $cadenaVocales = str_split($cadena);
    foreach($cadenaVocales as $valor){
        if(in_array($valor,$vocales)){
            $contador++;
        }
    }
    return $contador;
}
$numeroVocales = contarVocales($cadena);
echo "El numero de vocales en la cadena es: ". $numeroVocales;
?>

<!-- • Objetivo: Practicar el uso de arrays, bucles y operadores aritméticos. 
• Descripción: 
1. Crea un array de números con al menos 5 elementos. 
2. Escribe un algoritmo que calcule el promedio de los números en el array. 
3. Muestra el promedio.  -->
<?php
$numeros = array(10,20,35,48,62);
function calcularPromedio($numeros){
    $suma = 0;
    foreach($numeros as $numero){
        $suma += $numero;
    }
    $promedio = $suma /count($numeros);
    return $promedio;
}
$promedio = calcularPromedio($numeros);
echo "<br> <br>";
echo "El promedio de los números en el array es: " . $promedio;

?>



<!-- • Objetivo: Implementar un algoritmo para calcular la suma de todos los 
elementos de un array. 
• Descripción: 
1. Crea un array numérico con al menos 5 elementos. 
2. Escribe un algoritmo que recorra el array y sume todos los elementos. 
3. Muestra el resultado de la suma.  -->
<?php
$numeros = array(1,2,3,4,5);
$suma=0;
foreach($numeros as $numero){
    $suma+=$numero;
}
echo "<br> <br>";

echo "La suma de los números en el array es: " . $suma;


?>

<!-- • Objetivo: Implementar un algoritmo para eliminar elementos duplicados de un 
array sin usar array_unique(). 
• Descripción: 
1. Crea un array con algunos elementos duplicados. 
2. Escribe un algoritmo que elimine los duplicados manteniendo solo la 
primera aparición de cada elemento. 
3. Muestra el array sin duplicados.  -->

<?php
$duplicados = array(2, 2, 8, 5, 3, 8, 1, 2, 5, 7, 3, 4, 6, 1);
$unicos = array();
foreach($duplicados as $duplicado){
    if(!in_array($duplicado,$unicos)){
        array_push($unicos,$duplicado);
    }
}
echo "<br> <br>";

var_dump($unicos);
?>



<!-- 
• Objetivo: Implementar un algoritmo para contar cuántas veces aparece cada 
elemento en un array. 
• Descripción: 
1. Crea un array con algunos elementos repetidos. 
2. Escribe un algoritmo que cuente la frecuencia de cada elemento. 
3. Muestra el número de veces que aparece cada elemento.  -->

<?php
$frecuencias = array(2, 2, 6, 1, 2, 6, 1, 6, 7, 1);
$frecuencia = array();
foreach($frecuencias as $elemento){
    if(isset($frecuencia[$elemento])){
        $frecuencia[$elemento]++;
    }else{
        $frecuencia[$elemento] = 1;
    }
}
echo "<br><br>";
foreach($frecuencia as $elemento =>$repetir){
    echo "El elemento $elemento aparece $repetir veces.<br>";}
?>


