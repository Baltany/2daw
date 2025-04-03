<!-- 
• Objetivo: Practicar la creación y acceso a elementos de un array. 
• Descripción: 
1. Crea un array llamado $colores que contenga los colores "rojo", 
"verde", "azul", "amarillo". 
2. Muestra el primer y el tercer elemento del array. 
3. Agrega un nuevo color "naranja" al array. 
4. Muestra todos los elementos del array usando un bucle for.  -->

<?php
$colores = array("rojo","verde","azul","amarillo");
echo "Muestro los colores primero y tercero: 1.color:" . $colores[0] . ", color 3:" . $colores[2];
array_push($colores,"naranja");
echo "Mostrando lista una vez anadimos el nuevo color:<br>";
print_r($colores);

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
$persona = array("nombre" => "Juan","edad" => 25,"ciudad" => "Madrid");
echo "Nombre: " . $persona["nombre"] . " y la ciudad: " . $persona["ciudad"];
$persona ["profesion"] = "Ingeniero";
print_r($persona);
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
// Mostrando los numeros del array en orden descendente
print_r($numeros);
// Mostrando los numeros del array en orden ascendente
rsort($numeros);
print_r($numeros);
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
echo "La cantidad de animales en el array es: ".count($animales) . " animales";
$animales[] = "pajaro";
$animales[] = "pez";
echo "<br>";
echo "<br>La cantidad actualizada de animales en el array es: ".count($animales) . " animales";
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
    array("nombre" => "Producto1","precio" => "10", "cantidad" => "5"),
    array("nombre" => "Producto2","precio" => "5", "cantidad" => "1"),
    array("nombre" => "Producto3","precio" => "8", "cantidad" => "3")
);


echo "El nombre del segundo producto es: ". $productos[1]["nombre"]  . " y el precio del mismo es: ". $productos[1]["precio"] . "€";
echo "<br>";
echo "<br>";
echo "Mostrando los productos con un foreach";


foreach($productos as $i=>$valor){
    echo "Producto " . ($i + 1) . " Nombre: " . $valor["nombre"] . ", Precio: " . $valor["precio"] . "€ y la cantidad es: ". $valor["cantidad"] . "<br>";
}
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
$nombres = array("ana","luis","carlos","maria");
echo "Mostrando el array en orden inverso: " . print_r(array_reverse($nombres));
echo "<br>";
echo "<br>";

if(in_array("carlos",$nombres)){
    echo "carlos se encuentra en el array";
}else{
    echo "carlos NO se encuentra en el array";
    return;
}
array_push($nombres,"Juan");
echo "Array actualizado: ";
print_r($nombres);
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
$paises = array("España","Francia","Italia","Alemania","Portugal");
// el metodo unset elimina un elemento del array que se le pida
unset($paises[2]);
echo "Array sin Italia: ";
print_r($paises);
// el metodo pop elimina el ultimo elemento del array
array_pop($paises);
echo "<br>";
echo "Array sin el ultimo elemento: ";
print_r($paises);
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
$edades = array(20,30,40,25,35);
$posicion = array_search(25,$edades);
if($posicion != false){
    echo "La posicion de la edad 25 es: " . $posicion + 1;
}else{
    echo "No se encontro la edad 25 en el array";
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
$numeros = array(10, 20, 5, 30, 15);
// Importante inicializar el maximo y el minimo con el PRIMER valor del array
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
$cadena = "Soy un texto de prueba para contar las vocales";

function contarVocales($cadena){
    $vocales = array("a","e","i","o","u","A","E","I","O","U");
    $contador = 0;

    // el split lo que hace es convertirlo a a array para que podamos recorrerlo con el foreach
    $cadenaUsuario = str_split($cadena);

    foreach($cadenaUsuario as $valor){
        if(in_array($valor,$vocales)){
            $contador++;
        }

    }
    return $contador;

}
$numeroDeVocales = contarVocales($cadena);
echo "El número de vocales en la cadena es: " . $numeroDeVocales;

?>


<!-- • Objetivo: Practicar el uso de arrays, bucles y operadores aritméticos. 
• Descripción: 
1. Crea un array de números con al menos 5 elementos. 
2. Escribe un algoritmo que calcule el promedio de los números en el array. 
3. Muestra el promedio.  -->

<?php
$numeros = array(10, 20, 30, 40, 50);

function calcularPromedio($numeros){
    $suma = 0;
    foreach($numeros as $numero){
        $suma += $numero;
    }
    $promedio = $suma / count($numeros);
    return $promedio;
}
$promedio = calcularPromedio($numeros);
echo "El promedio de los números en el array es: " . $promedio;

?>


<!-- • Objetivo: Implementar un algoritmo para calcular la suma de todos los 
elementos de un array. 
• Descripción: 
1. Crea un array numérico con al menos 5 elementos. 
2. Escribe un algoritmo que recorra el array y sume todos los elementos. 
3. Muestra el resultado de la suma.  -->

<?php
$numeros = array(1, 2, 3, 4, 5);

function calcularSuma($numeros){
    $suma = 0;
    foreach($numeros as $numero){
        $suma += $numero;
    }
    return $suma;
}
$total = calcularSuma($numeros);
echo "La suma de los números en el array es: " . $total;

?>

<!-- • Objetivo: Implementar un algoritmo para eliminar elementos duplicados de un 
array sin usar array_unique(). 
• Descripción: 
1. Crea un array con algunos elementos duplicados. 
2. Escribe un algoritmo que elimine los duplicados manteniendo solo la 
primera aparición de cada elemento. 
3. Muestra el array sin duplicados.  -->
<?php
$elementos = array(2, 2, 8, 5, 3, 8, 1, 2, 5, 7, 3, 4, 6, 1);

function eliminarDuplicados($elementos){
    $elementosSinDuplicados = array();
    foreach($elementos as $elemento){
        // Primero recorremos el array de duplicados
        // una vez recorrido si el elemento que se recorre no se encuentra en el array sin duplicados
        // le hacemos un push
        if(!in_array($elemento,$elementosSinDuplicados)){
            array_push($elementosSinDuplicados,$elemento);
        }
    }
    return $elementosSinDuplicados;
}
$elementosSinDuplicados = eliminarDuplicados($elementos);
echo "Array sin duplicados: ";
print_r($elementosSinDuplicados);
?>

<!-- 
• Objetivo: Implementar un algoritmo para contar cuántas veces aparece cada 
elemento en un array. 
• Descripción: 
1. Crea un array con algunos elementos repetidos. 
2. Escribe un algoritmo que cuente la frecuencia de cada elemento. 
3. Muestra el número de veces que aparece cada elemento.  -->
<?php
$elementos = array(2, 2, 6, 1, 2, 6, 1, 6, 7, 1);

function contarFrecuencias($elementos){
    // Crear un array vacío para almacenar las frecuencias
    $frecuencias = array();
    
    // Recorrer el array de elementos
    foreach($elementos as $elemento){
        // Si el elemento ya está en el array de frecuencias, incrementar su contador
        if(isset($frecuencias[$elemento])){
            $frecuencias[$elemento]++;
        } else {
            // Si no está, agregarlo con un contador inicial de 1
            $frecuencias[$elemento] = 1;
        }
    }
    
    return $frecuencias;
}

// Llamamos a la función para contar las frecuencias
$frecuencias = contarFrecuencias($elementos);

// Mostrar las frecuencias
echo "Frecuencia de los elementos en el array: <br>";
foreach($frecuencias as $elemento => $cantidad){
    echo "El elemento $elemento aparece $cantidad veces.<br>";
}
?>