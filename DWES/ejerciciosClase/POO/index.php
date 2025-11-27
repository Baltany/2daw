<?php
    require_once 'persona.php';
    $p = new Persona();

    //echo $p->getNombre();
    echo "<br>".Persona::numPersona();
    $p1 = new Persona("Maria","Carpio",34);
    echo "<br>".Persona::numPersona();
    unset($p1);
    echo "<br>".Persona::numPersona();
    echo "<br>================<br>";
    $p->nombre="Alejandro";
    echo $p->nombre;
    //echo "<br> Mi nombre es ".$p->nombre." ".$p->apellidos." y tengo ".$p->edad." años "
    echo $p;
    $p2=clone($p);
    echo $p2;
    $p2->nombre="Juan";
    echo $p;
    echo $p2;
    echo "<br>".Persona::numPersona();
    $p->modificar("Miguel","Gutierrez",90);
    echo $p."<br>";
    $p_json=json_encode($p);
    var_dump($p_json);
    $p3=json_decode($p_json);
    echo "<br>";
    var_dump($p3);
    
?>