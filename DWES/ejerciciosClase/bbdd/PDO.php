<?php
try {
    // forma de crear un pdo de forma muy parecida a un objeto mysqli
    $opciones=array(PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_OBJ,PDO::ATTR_CASE=>PDO::CASE_LOWER);
    $conex= new PDO('mysql:host=localhost;dbname=dwes;charset=utf8mb4','dwes','abc123.',$opciones);
    // quitar autocommit pq es dependiente
    $conex->beginTransaction();
    // El exec devuelve un entero y se usa cuando no devuelve resultados, devuelve un numero de filas afectadas affect_row(mysqli), en cambio query devuelve resulatados
    $reg1 = $conex->exec("UPDATE stock set unidades=200 where producto='3DSNG'");
    $reg2 = $conex->exec("UPDATE stock set unidades=500 where producto='ARCLPMP32GBN'");
    if($reg1 === 0)echo "No se ha actualizado el producto";
    if($reg2 === 0)echo "No se ha actualizado el producto";
    $conex -> commit();
} catch (PDOException $ex) {
    echo $ex->getMessage()."<br>";
    print_r($ex->errorInfo);
}


echo "Consultas";
try{
    $result = $conex->query("SELECT * FROM producto");
    echo "Numero de filas devuelto". $result->rowCount()."<br>";
    while($fila = $result->fetch()){
        var_dump($fila);
        echo "<br>";
    }
}catch(PDOException $e){
    echo $th->getMessage();
}

echo "Consultas preparadas";
try{
    $menor=100;
    $mayor=200;
    $result = $conex -> prepare("SELECT * from producto where PVP>? and PVP<?");
    for($i=0;$i<1000;$i+=100){
        $result->bind_param(1,$menor);
        $result->bind_param(2,$mayor);
        $result -> execute();
        $menor+=$i;
        $mayor+=$i;
        while($fila = $result->fetch()){
            echo "Nombre: " . $fila -> nombre_corto . "<br>";
        }

    }
}



?>